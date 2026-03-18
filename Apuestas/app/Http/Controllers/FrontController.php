<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Challenge;
use App\Models\Bet;
use App\Models\MineGame;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function home() 
    {
        $user = Auth::user();

        // 1. Estadísticas básicas
        $wonBets = Bet::where('user_id', $user->id)->where('status', 'won')->count();
        $pendingBets = Bet::where('user_id', $user->id)->where('status', 'pending')->count();
        $scheduledMatches = GameMatch::where('status', 'scheduled')->count();
        
        // 2. Solución para image_e8db5c.png (Mis últimas apuestas)
        $myBets = Bet::where('user_id', $user->id)->latest()->take(5)->get();

        // 3. Solución para image_e9447a.png (Próximos partidos)
        $nextMatches = GameMatch::with(['sport', 'teamHome', 'teamAway'])
            ->where('status', 'scheduled')
            ->latest()
            ->take(6)
            ->get();

        // 4. Desafíos pendientes
        $pendingChallenges = Challenge::where('opponent_id', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('front.home', compact(
            'wonBets', 
            'pendingBets', 
            'scheduledMatches', 
            'myBets', 
            'nextMatches', 
            'pendingChallenges'
        ));
    }

    public function mines()
    {
        $user = Auth::user();
        $activeGame = MineGame::where('user_id', $user->id)->where('status', 'playing')->first();
        return view('front.mines', compact('activeGame'));
    }

    public function challenges()
    {
        $user = Auth::user();
        $stats = [
            'total' => Challenge::where('creator_id', $user->id)->orWhere('opponent_id', $user->id)->count(),
            'pending' => Challenge::where('status', 'pending')->count(),
            'accepted' => Challenge::where('status', 'accepted')->count(),
            'rejected' => Challenge::where('status', 'rejected')->count(),
        ];
        $activeChallenges = Challenge::where('opponent_id', $user->id)->where('status', 'pending')->get();
        return view('front.challenges', compact('activeChallenges', 'stats'));
    }

    public function matches()
    {
        $matches = GameMatch::with(['sport', 'teamHome', 'teamAway'])->latest()->get();
        return view('front.matches', compact('matches'));
    }
}