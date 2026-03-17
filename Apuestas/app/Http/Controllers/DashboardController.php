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

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Opcional: proteger todo el dash solo para admin
        // $this->middleware(function($req, $next) {
        //     abort_unless(Auth::user()->role === 'admin', 403);
        //     return $next($req);
        // });
    }

    // ── INDEX ──────────────────────────────────────────────
    public function index()
    {
        $totalUsers        = User::count();
        $newUsersToday     = User::whereDate('created_at', today())->count();
        $totalBets         = Bet::count();
        $pendingBets       = Bet::where('status', 'pending')->count();
        $scheduledMatches  = GameMatch::where('status', 'scheduled')->count();
        $finishedMatches   = GameMatch::where('status', 'finished')->count();
        $totalBalance      = User::sum('balance');
        $totalTransactions = Transaction::count();

        $recentBets = Bet::with(['user', 'match.teamHome', 'match.teamAway'])
            ->latest()->take(6)->get();

        $recentTransactions = Transaction::with('user')
            ->latest()->take(6)->get();

        $nextMatches = GameMatch::with(['sport', 'teamHome', 'teamAway'])
            ->where('status', 'scheduled')
            ->orderBy('match_date')->take(5)->get();

        $recentMines = MineGame::with('user')
            ->latest()->take(6)->get();

        return view('dash.index', compact(
            'totalUsers', 'newUsersToday', 'totalBets', 'pendingBets',
            'scheduledMatches', 'finishedMatches', 'totalBalance', 'totalTransactions',
            'recentBets', 'recentTransactions', 'nextMatches', 'recentMines'
        ));
    }

    // ── USERS ──────────────────────────────────────────────
    public function users()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $users = User::withCount(['bets', 'transactions'])
            ->orderByDesc('created_at')->paginate(20);

        $stats = [
            'total'         => User::count(),
            'admins'        => User::where('role', 'admin')->count(),
            'users'         => User::where('role', 'user')->count(),
            'total_balance' => User::sum('balance'),
        ];

        return view('dash.users', compact('users', 'stats'));
    }

    // ── BETS ───────────────────────────────────────────────
    public function bets()
    {
        $bets = Bet::with(['user', 'match.teamHome', 'match.teamAway', 'match.sport', 'odd'])
            ->latest()->paginate(20);

        $all = Bet::query();
        $stats = [
            'total'          => (clone $all)->count(),
            'won'            => (clone $all)->where('status', 'won')->count(),
            'lost'           => (clone $all)->where('status', 'lost')->count(),
            'pending'        => (clone $all)->where('status', 'pending')->count(),
            'total_won'      => (clone $all)->where('status', 'won')->sum('potential_win'),
            'total_lost'     => (clone $all)->where('status', 'lost')->sum('amount'),
            'pending_amount' => (clone $all)->where('status', 'pending')->sum('amount'),
        ];

        return view('dash.bets', compact('bets', 'stats'));
    }

    // ── MATCHES ────────────────────────────────────────────
    public function matches(Request $request)
    {
        $query = GameMatch::with(['sport', 'teamHome', 'teamAway', 'odds']);

        if ($request->filled('sport'))  $query->where('sport_id', $request->sport);
        if ($request->filled('status')) $query->where('status', $request->status);

        $matches = $query->orderByDesc('match_date')->paginate(15);
        $sports  = Sport::orderBy('name')->get();

        return view('dash.matches', compact('matches', 'sports'));
    }

    // ── MINES ──────────────────────────────────────────────
    public function mines()
    {
        $games = MineGame::with('user')->latest()->paginate(20);

        $all = MineGame::query();
        $stats = [
            'total'           => (clone $all)->count(),
            'won'             => (clone $all)->where('status', 'won')->count(),
            'lost'            => (clone $all)->where('status', 'lost')->count(),
            'playing'         => (clone $all)->where('status', 'playing')->count(),
            'total_winnings'  => (clone $all)->where('status', 'won')->sum('winnings'),
            'total_lost'      => (clone $all)->where('status', 'lost')->sum('bet_amount'),
            'in_play'         => (clone $all)->where('status', 'playing')->sum('bet_amount'),
        ];

        return view('dash.mines', compact('games', 'stats'));
    }

    // ── CHALLENGES ─────────────────────────────────────────
    public function challenges()
    {
        $challenges = Challenge::with(['creator', 'opponent', 'challengeBets'])
            ->latest()->paginate(20);

        $all = Challenge::query();
        $stats = [
            'total'     => (clone $all)->count(),
            'pending'   => (clone $all)->where('status', 'pending')->count(),
            'accepted'  => (clone $all)->where('status', 'accepted')->count(),
            'completed' => (clone $all)->where('status', 'completed')->count(),
        ];

        return view('dash.challenges', compact('challenges', 'stats'));
    }

    // ── TRANSACTIONS ───────────────────────────────────────
    public function transactions()
    {
        $transactions = Transaction::with('user')->latest()->paginate(25);

        $stats = [
            'deposits'    => Transaction::where('type', 'deposit')->sum('amount'),
            'withdrawals' => Transaction::where('type', 'withdrawal')->sum('amount'),
            'bet_wins'    => Transaction::where('type', 'bet_win')->sum('amount'),
        ];

        return view('dash.transactions', compact('transactions', 'stats'));
    }
}