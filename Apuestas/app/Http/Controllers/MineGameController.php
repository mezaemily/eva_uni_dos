<?php
namespace App\Http\Controllers;

use App\Models\MineGame;
use App\Models\MineTile;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MineGameController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'bet_amount' => 'required|numeric|min:1',
            'mines'      => 'required|integer|min:1|max:24',
        ], [
            'bet_amount.required' => 'El monto de apuesta es obligatorio.',
            'bet_amount.min'      => 'La apuesta mínima es $1.',
            'mines.required'      => 'Selecciona el número de minas.',
            'mines.min'           => 'Mínimo 1 mina.',
            'mines.max'           => 'Máximo 24 minas.',
        ]);

        $user = Auth::user();

        if ($user->balance < $request->bet_amount) {
            return response()->json(['error' => 'Saldo insuficiente.'], 422);
        }

        return DB::transaction(function () use ($request, $user) {
            MineGame::where('user_id', $user->id)
                ->where('status', 'playing')
                ->update(['status' => 'lost']);

            $game = MineGame::create([
                'user_id'    => $user->id,
                'bet_amount' => $request->bet_amount,
                'mines'      => $request->mines,
                'multiplier' => 1.00,
                'winnings'   => 0,
                'status'     => 'playing',
            ]);

            $positions = range(0, 24);
            shuffle($positions);
            $minePositions = array_slice($positions, 0, $request->mines);

            $tiles = [];
            for ($i = 0; $i < 25; $i++) {
                $tiles[] = [
                    'game_id'  => $game->id,
                    'position' => $i,
                    'is_mine'  => in_array($i, $minePositions),
                    'revealed' => false,
                ];
            }
            MineTile::insert($tiles);

            $user->decrement('balance', $request->bet_amount);

            Transaction::create([
                'user_id'     => $user->id,
                'type'        => 'bet',
                'amount'      => $request->bet_amount,
                'description' => "Apuesta Mines partida #{$game->id}",
            ]);

            return response()->json([
                'success'    => true,
                'game_id'    => $game->id,
                'bet_amount' => $game->bet_amount,
                'mines'      => $game->mines,
                'multiplier' => $this->calcMultiplier(0, $game->mines),
                'balance'    => $user->fresh()->balance,
            ]);
        });
    }

    public function reveal(Request $request)
    {
        $request->validate([
            'game_id'  => 'required|exists:mine_games,id',
            'position' => 'required|integer|between:0,24',
        ]);

        $user = Auth::user();
        $game = MineGame::where('id', $request->game_id)
            ->where('user_id', $user->id)
            ->where('status', 'playing')
            ->first();

        if (!$game) {
            return response()->json(['error' => 'Partida no válida.'], 422);
        }

        $tile = MineTile::where('game_id', $game->id)
            ->where('position', $request->position)
            ->first();

        if (!$tile || $tile->revealed) {
            return response()->json(['error' => 'Celda inválida.'], 422);
        }

        $tile->update(['revealed' => true]);

        if ($tile->is_mine) {
            $game->update(['status' => 'lost', 'winnings' => 0]);

            $allMines = MineTile::where('game_id', $game->id)
                ->where('is_mine', true)
                ->pluck('position');

            return response()->json([
                'result'    => 'mine',
                'position'  => $request->position,
                'mines'     => $allMines,
                'game_over' => true,
                'winnings'  => 0,
                'balance'   => $user->fresh()->balance,
            ]);
        }

        $revealed   = MineTile::where('game_id', $game->id)
            ->where('is_mine', false)
            ->where('revealed', true)
            ->count();

        $safeCells  = 25 - $game->mines;
        $multiplier = $this->calcMultiplier($revealed, $game->mines);
        $potential  = round($game->bet_amount * $multiplier, 2);

        $game->update(['multiplier' => $multiplier]);

        if ($revealed >= $safeCells) {
            return $this->doCashout($game, $user, $multiplier);
        }

        return response()->json([
            'result'     => 'safe',
            'position'   => $request->position,
            'revealed'   => $revealed,
            'safe_cells' => $safeCells,
            'multiplier' => $multiplier,
            'potential'  => $potential,
            'game_over'  => false,
        ]);
    }

    public function cashout(Request $request)
    {
        $request->validate(['game_id' => 'required|exists:mine_games,id']);

        $user = Auth::user();
        $game = MineGame::where('id', $request->game_id)
            ->where('user_id', $user->id)
            ->where('status', 'playing')
            ->first();

        if (!$game) {
            return response()->json(['error' => 'No hay partida activa.'], 422);
        }

        $revealed = MineTile::where('game_id', $game->id)
            ->where('is_mine', false)
            ->where('revealed', true)
            ->count();

        if ($revealed === 0) {
            return response()->json(['error' => 'Debes revelar al menos una celda.'], 422);
        }

        return $this->doCashout($game, $user, $game->multiplier);
    }

    public function status()
    {
        $user = Auth::user();

        // Cancelar cualquier partida en curso al entrar a la página
        MineGame::where('user_id', $user->id)
            ->where('status', 'playing')
            ->update(['status' => 'lost']);

        $game = MineGame::where('user_id', $user->id)
            ->where('status', 'playing')
            ->latest()
            ->first();

        if (!$game) {
            return response()->json(['active' => false]);
        }

        $revealedTiles = MineTile::where('game_id', $game->id)
            ->where('revealed', true)
            ->where('is_mine', false)
            ->pluck('position');

        $revealed   = $revealedTiles->count();
        $multiplier = $this->calcMultiplier($revealed, $game->mines);

        return response()->json([
            'active'         => true,
            'game_id'        => $game->id,
            'bet_amount'     => $game->bet_amount,
            'mines'          => $game->mines,
            'multiplier'     => $multiplier,
            'potential'      => round($game->bet_amount * $multiplier, 2),
            'revealed'       => $revealedTiles,
            'revealed_count' => $revealed,
        ]);
    }

    private function doCashout(MineGame $game, $user, float $multiplier)
    {
        $winnings = round($game->bet_amount * $multiplier, 2);

        DB::transaction(function () use ($game, $user, $winnings, $multiplier) {
            $game->update([
                'status'     => 'won',
                'winnings'   => $winnings,
                'multiplier' => $multiplier,
            ]);

            $user->increment('balance', $winnings);

            Transaction::create([
                'user_id'     => $user->id,
                'type'        => 'bet_win',
                'amount'      => $winnings,
                'description' => "Ganancia Mines partida #{$game->id} x{$multiplier}",
            ]);
        });

        $allMines = MineTile::where('game_id', $game->id)
            ->where('is_mine', true)
            ->pluck('position');

        return response()->json([
            'result'     => 'cashout',
            'winnings'   => $winnings,
            'multiplier' => $multiplier,
            'mines'      => $allMines,
            'game_over'  => true,
            'balance'    => $user->fresh()->balance,
        ]);
    }

    private function calcMultiplier(int $revealed, int $mines): float
    {
        $total = 25;
        $safe  = $total - $mines;
        $prob  = 1.0;

        for ($i = 0; $i < $revealed; $i++) {
            $prob *= ($safe - $i) / ($total - $i);
        }

        if ($prob <= 0) return 1.0;

        $multiplier = (1 / $prob) * 0.97;
        return round(max($multiplier, 1.01), 2);
    }
}