<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bet;
use App\Models\Transaction;
use App\Models\GameMatch;
use App\Models\MineGame;
use App\Models\Challenge;
use App\Models\Sport;
use App\Models\User;

class FrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── HOME / LOBBY ───────────────────────────────────────
    public function home()
    {
        $user = Auth::user();

        $wonBets        = Bet::where('user_id', $user->id)->where('status', 'won')->count();
        $pendingBets    = Bet::where('user_id', $user->id)->where('status', 'pending')->count();
        $scheduledMatches = GameMatch::where('status', 'scheduled')->count();
        $pendingChallenges = Challenge::where(function($q) use ($user) {
            $q->where('creator_id', $user->id)->orWhere('opponent_id', $user->id);
        })->where('status', 'pending')->count();

        $nextMatches = GameMatch::with(['sport', 'teamHome', 'teamAway'])
            ->where('status', 'scheduled')
            ->orderBy('match_date')
            ->take(4)
            ->get();

        $myBets = Bet::with(['match.teamHome', 'match.teamAway', 'odd'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('front.home', compact(
            'wonBets', 'pendingBets', 'scheduledMatches',
            'pendingChallenges', 'nextMatches', 'myBets'
        ));
    }

    // ── MATCHES ────────────────────────────────────────────
    public function matches(Request $request)
    {
        $query = GameMatch::with(['sport', 'teamHome', 'teamAway', 'odds', 'comments'])
            ->where('status', 'scheduled');

        if ($request->filled('sport')) {
            $query->where('sport_id', $request->sport);
        }

        $matches = $query->orderBy('match_date')->paginate(9);
        $sports  = Sport::orderBy('name')->get();

        return view('front.matches', compact('matches', 'sports'));
    }

    // ── MINES ──────────────────────────────────────────────
    public function mines()
    {
        $user = Auth::user();

        $activeGame = MineGame::with('tiles')
            ->where('user_id', $user->id)
            ->where('status', 'playing')
            ->latest()
            ->first();

        $recentGames = MineGame::where('user_id', $user->id)
            ->latest()
            ->take(8)
            ->get();

        $all = MineGame::where('user_id', $user->id);

        $stats = [
            'total'           => (clone $all)->count(),
            'won'             => (clone $all)->where('status', 'won')->count(),
            'lost'            => (clone $all)->where('status', 'lost')->count(),
            'total_winnings'  => (clone $all)->where('status', 'won')->sum('winnings'),
        ];

        return view('front.mines', compact('activeGame', 'recentGames', 'stats'));
    }

    // ── CHALLENGES ─────────────────────────────────────────
    public function challenges()
    {
        $user = Auth::user();

        $challenges = Challenge::with(['creator', 'opponent', 'challengeBets'])
            ->where(function($q) use ($user) {
                $q->where('creator_id', $user->id)
                  ->orWhere('opponent_id', $user->id);
            })
            ->latest()
            ->paginate(15);

        $all = Challenge::where(function($q) use ($user) {
            $q->where('creator_id', $user->id)->orWhere('opponent_id', $user->id);
        });

        $stats = [
            'total'    => (clone $all)->count(),
            'pending'  => (clone $all)->where('status', 'pending')->count(),
            'accepted' => (clone $all)->where('status', 'accepted')->count(),
            'rejected' => (clone $all)->where('status', 'rejected')->count(),
        ];

        return view('front.challenges', compact('challenges', 'stats'));
    }

    // ── MY BETS ────────────────────────────────────────────
    public function mybets()
    {
        $user = Auth::user();

        $bets = Bet::with(['match.teamHome', 'match.teamAway', 'match.sport', 'odd'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        $all = Bet::where('user_id', $user->id);

        $stats = [
            'total'          => (clone $all)->count(),
            'won'            => (clone $all)->where('status', 'won')->count(),
            'lost'           => (clone $all)->where('status', 'lost')->count(),
            'pending'        => (clone $all)->where('status', 'pending')->count(),
            'won_amount'     => (clone $all)->where('status', 'won')->sum('potential_win'),
            'lost_amount'    => (clone $all)->where('status', 'lost')->sum('amount'),
            'pending_amount' => (clone $all)->where('status', 'pending')->sum('amount'),
        ];

        return view('front.mybets', compact('bets', 'stats'));
    }

    // ── PROFILE ────────────────────────────────────────────
    public function profile()
    {
        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $stats = [
            'totalBets'  => Bet::where('user_id', $user->id)->count(),
            'wonBets'    => Bet::where('user_id', $user->id)->where('status', 'won')->count(),
            'mineGames'  => MineGame::where('user_id', $user->id)->count(),
            'followers'  => \App\Models\Follower::where('following_id', $user->id)->count(),
        ];

        return view('front.profile', compact('transactions', 'stats'));
    }
}