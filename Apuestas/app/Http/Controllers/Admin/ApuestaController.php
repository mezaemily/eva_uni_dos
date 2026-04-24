<?php
// app/Http/Controllers/Admin/ApuestaController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\GameMatch;
use App\Models\Odd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApuestaController extends Controller
{
    /** GET /admin/crud/apuestas */
    public function index(Request $request)
    {
        $query = Bet::with(['user', 'match.teamHome', 'match.teamAway', 'odd.betType'])
            ->orderByDesc('created_at');

        // Filtros opcionales
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $apuestas = $query->paginate(20)->withQueryString();

        return view('admin.apuestas.index', compact('apuestas'));
    }

    /** GET /admin/crud/apuestas/crear */
    public function create()
    {
        $usuarios = User::orderBy('username')->get(['id', 'username']);
        $partidos = GameMatch::with(['teamHome', 'teamAway'])
            ->where('status', 'scheduled')
            ->orderBy('match_date')
            ->get();
        $odds = Odd::with('betType')->get();

        return view('admin.apuestas.create', compact('usuarios', 'partidos', 'odds'));
    }

    /** POST /admin/crud/apuestas */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'match_id' => 'required|exists:matches,id',
            'odd_id'   => 'required|exists:odds,id',
            'amount'   => 'required|numeric|min:1',
        ]);

        $odd  = Odd::findOrFail($request->odd_id);
        $user = User::findOrFail($request->user_id);

        if ($user->balance < $request->amount) {
            return back()->withErrors(['amount' => 'El usuario no tiene saldo suficiente.'])->withInput();
        }

        DB::transaction(function () use ($request, $odd, $user) {
            $bet = Bet::create([
                'user_id'       => $user->id,
                'match_id'      => $request->match_id,
                'odd_id'        => $odd->id,
                'amount'        => $request->amount,
                'potential_win' => round($request->amount * $odd->odd_value, 2),
                'status'        => 'pending',
            ]);

            $user->decrement('balance', $request->amount);

            $user->transactions()->create([
                'type'        => 'apuesta',
                'amount'      => $request->amount,
                'description' => "Apuesta #{$bet->id} creada por administrador",
            ]);
        });

        return redirect()->route('admin.apuestas.index')
            ->with('success', 'Apuesta creada correctamente.');
    }

    /** GET /admin/crud/apuestas/{apuesta} */
    public function show(Bet $apuesta)
    {
        $apuesta->load(['user', 'match.teamHome', 'match.teamAway', 'odd.betType']);

        return view('admin.apuestas.show', compact('apuesta'));
    }

    /** GET /admin/crud/apuestas/{apuesta}/editar */
    public function edit(Bet $apuesta)
    {
        $apuesta->load(['user', 'match', 'odd']);

        return view('admin.apuestas.edit', compact('apuesta'));
    }

    /** PUT /admin/crud/apuestas/{apuesta} */
    public function update(Request $request, Bet $apuesta)
    {
        $request->validate([
            'status' => 'required|in:pending,won,lost,cancelled',
        ]);

        $estadoAnterior = $apuesta->status;
        $apuesta->update(['status' => $request->status]);

        // Si gana: acreditar ganancia
        if ($request->status === 'won' && $estadoAnterior !== 'won') {
            DB::transaction(function () use ($apuesta) {
                $apuesta->user->increment('balance', $apuesta->potential_win);
                $apuesta->user->transactions()->create([
                    'type'        => 'ganancia',
                    'amount'      => $apuesta->potential_win,
                    'description' => "Ganancia de apuesta #{$apuesta->id}",
                ]);
            });
        }

        // Si se cancela: devolver el monto apostado
        if ($request->status === 'cancelled' && $estadoAnterior === 'pending') {
            DB::transaction(function () use ($apuesta) {
                $apuesta->user->increment('balance', $apuesta->amount);
                $apuesta->user->transactions()->create([
                    'type'        => 'devolucion',
                    'amount'      => $apuesta->amount,
                    'description' => "Devolución de apuesta #{$apuesta->id} cancelada",
                ]);
            });
        }

        return redirect()->route('admin.apuestas.index')
            ->with('success', 'Apuesta actualizada correctamente.');
    }

    /** DELETE /admin/crud/apuestas/{apuesta} */
    public function destroy(Bet $apuesta)
    {
        if ($apuesta->status !== 'pending') {
            return back()->with('error', 'Solo se pueden eliminar apuestas en estado pendiente.');
        }

        DB::transaction(function () use ($apuesta) {
            // Devolver saldo al usuario
            $apuesta->user->increment('balance', $apuesta->amount);
            $apuesta->user->transactions()->create([
                'type'        => 'devolucion',
                'amount'      => $apuesta->amount,
                'description' => "Devolución por eliminación de apuesta #{$apuesta->id}",
            ]);
            $apuesta->delete();
        });

        return redirect()->route('admin.apuestas.index')
            ->with('success', 'Apuesta eliminada y saldo devuelto.');
    }

    /**
     * PATCH /admin/crud/apuestas/resolver-partido/{partido}
     * Resuelve todas las apuestas de un partido según resultado.
     */
    public function resolverPartido(GameMatch $partido)
    {
        $apuestas = Bet::with(['user', 'odd.betType'])
            ->where('match_id', $partido->id)
            ->where('status', 'pending')
            ->get();

        DB::transaction(function () use ($apuestas, $partido) {
            foreach ($apuestas as $apuesta) {
                $gana = $this->evaluarApuesta($apuesta, $partido);

                $apuesta->update(['status' => $gana ? 'won' : 'lost']);

                if ($gana) {
                    $apuesta->user->increment('balance', $apuesta->potential_win);
                    $apuesta->user->transactions()->create([
                        'type'        => 'ganancia',
                        'amount'      => $apuesta->potential_win,
                        'description' => "Ganancia apuesta #{$apuesta->id} — partido #{$partido->id}",
                    ]);
                }
            }
        });

        return redirect()->back()
            ->with('success', "Apuestas del partido #{$partido->id} resueltas.");
    }

    /**
     * Lógica de evaluación por tipo de apuesta.
     */
    private function evaluarApuesta(Bet $apuesta, GameMatch $partido): bool
    {
        $tipo   = strtolower($apuesta->odd->betType->name ?? '');
        $opcion = strtolower($apuesta->odd->option_name ?? '');
        $local  = $partido->home_score;
        $visita = $partido->away_score;

        if (str_contains($tipo, '1x2') || str_contains($tipo, 'resultado')) {
            if ($opcion === '1' || str_contains($opcion, 'local'))  return $local > $visita;
            if ($opcion === 'x' || str_contains($opcion, 'empate')) return $local === $visita;
            if ($opcion === '2' || str_contains($opcion, 'visita')) return $visita > $local;
        }

        // Tipo desconocido: no gana
        return false;
    }
}