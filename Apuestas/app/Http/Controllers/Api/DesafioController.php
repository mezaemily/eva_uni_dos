<?php
// app/Http/Controllers/Api/DesafioController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesafioController extends Controller
{
    /** GET /api/desafios */
    public function index(Request $request)
    {
        $query = Challenge::with(['creator', 'opponent', 'challengeBets'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->paginate(20));
    }

    /** POST /api/desafios */
    public function store(Request $request)
    {
        $request->validate([
            'opponent_id' => 'required|exists:users,id|different:' . auth()->id(),
        ]);

        $desafio = Challenge::create([
            'creator_id'  => auth()->id(),
            'opponent_id' => $request->opponent_id,
            'status'      => 'pending',
        ]);

        return response()->json([
            'message' => 'Desafío creado correctamente.',
            'desafio' => $desafio->load(['creator', 'opponent']),
        ], 201);
    }

    /** GET /api/desafios/{desafio} */
    public function show(Challenge $desafio)
    {
        return response()->json(
            $desafio->load(['creator', 'opponent', 'challengeBets.user'])
        );
    }

    /** PUT /api/desafios/{desafio} */
    public function update(Request $request, Challenge $desafio)
    {
        $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled',
        ]);

        $estadoAnterior = $desafio->status;
        $desafio->update(['status' => $request->status]);

        // Si se cancela devolver montos apostados
        if ($request->status === 'cancelled' && $estadoAnterior !== 'cancelled') {
            DB::transaction(function () use ($desafio) {
                foreach ($desafio->challengeBets as $bet) {
                    $bet->user->increment('balance', $bet->amount);
                    $bet->user->transactions()->create([
                        'type'        => 'devolucion',
                        'amount'      => $bet->amount,
                        'description' => "Devolución por cancelación de desafío #{$desafio->id}",
                    ]);
                }
            });
        }

        return response()->json([
            'message' => 'Desafío actualizado.',
            'desafio' => $desafio->fresh()->load(['creator', 'opponent']),
        ]);
    }

    /** DELETE /api/desafios/{desafio} */
    public function destroy(Challenge $desafio)
    {
        if ($desafio->status === 'completed') {
            return response()->json(['error' => 'No se puede eliminar un desafío completado.'], 422);
        }

        DB::transaction(function () use ($desafio) {
            foreach ($desafio->challengeBets as $bet) {
                $bet->user->increment('balance', $bet->amount);
                $bet->user->transactions()->create([
                    'type'        => 'devolucion',
                    'amount'      => $bet->amount,
                    'description' => "Devolución por eliminación de desafío #{$desafio->id}",
                ]);
            }
            $desafio->challengeBets()->delete();
            $desafio->delete();
        });

        return response()->json(['message' => 'Desafío eliminado y saldos devueltos.']);
    }

    /**
     * POST /api/desafios/{desafio}/resolver
     * Declara ganador y distribuye el pozo.
     */
    public function resolver(Request $request, Challenge $desafio)
    {
        $request->validate([
            'ganador_id' => 'required|in:' . $desafio->creator_id . ',' . $desafio->opponent_id,
        ]);

        if ($desafio->status !== 'active') {
            return response()->json(['error' => 'Solo se pueden resolver desafíos activos.'], 422);
        }

        DB::transaction(function () use ($request, $desafio) {
            $pozo    = $desafio->challengeBets->sum('amount');
            $ganador = User::find($request->ganador_id);

            $ganador->increment('balance', $pozo);
            $ganador->transactions()->create([
                'type'        => 'ganancia',
                'amount'      => $pozo,
                'description' => "Premio desafío #{$desafio->id}",
            ]);

            $desafio->update(['status' => 'completed']);
        });

        return response()->json(['message' => 'Desafío resuelto y ganancia acreditada.']);
    }
}