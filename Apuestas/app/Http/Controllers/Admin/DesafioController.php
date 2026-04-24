<?php
// app/Http/Controllers/Admin/DesafioController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengeBet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesafioController extends Controller
{
    /** GET /admin/crud/desafios */
    public function index(Request $request)
    {
        $query = Challenge::with(['creator', 'opponent', 'challengeBets'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $desafios = $query->paginate(20)->withQueryString();

        return view('admin.desafios.index', compact('desafios'));
    }

    /** GET /admin/crud/desafios/crear */
    public function create()
    {
        $usuarios = User::where('role', 'user')->orderBy('username')->get(['id', 'username', 'balance']);

        return view('admin.desafios.create', compact('usuarios'));
    }

    /** POST /admin/crud/desafios */
    public function store(Request $request)
    {
        $request->validate([
            'creator_id'  => 'required|exists:users,id',
            'opponent_id' => 'required|exists:users,id|different:creator_id',
        ]);

        Challenge::create([
            'creator_id'  => $request->creator_id,
            'opponent_id' => $request->opponent_id,
            'status'      => 'pending',
        ]);

        return redirect()->route('admin.desafios.index')
            ->with('success', 'Desafío creado correctamente.');
    }

    /** GET /admin/crud/desafios/{desafio} */
    public function show(Challenge $desafio)
    {
        $desafio->load(['creator', 'opponent', 'challengeBets.user']);

        return view('admin.desafios.show', compact('desafio'));
    }

    /** GET /admin/crud/desafios/{desafio}/editar */
    public function edit(Challenge $desafio)
    {
        $usuarios = User::orderBy('username')->get(['id', 'username']);

        return view('admin.desafios.edit', compact('desafio', 'usuarios'));
    }

    /** PUT /admin/crud/desafios/{desafio} */
    public function update(Request $request, Challenge $desafio)
    {
        $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled',
        ]);

        $estadoAnterior = $desafio->status;
        $desafio->update(['status' => $request->status]);

        // Al cancelar: devolver montos de apuestas del desafío
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

        return redirect()->route('admin.desafios.index')
            ->with('success', 'Desafío actualizado correctamente.');
    }

    /** DELETE /admin/crud/desafios/{desafio} */
    public function destroy(Challenge $desafio)
    {
        if ($desafio->status === 'completed') {
            return back()->with('error', 'No se puede eliminar un desafío completado.');
        }

        DB::transaction(function () use ($desafio) {
            // Devolver saldo si hay apuestas asociadas
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

        return redirect()->route('admin.desafios.index')
            ->with('success', 'Desafío eliminado y saldos devueltos.');
    }

    /**
     * POST /admin/crud/desafios/{desafio}/resolver
     * Declara ganador y distribuye el pozo.
     */
    public function resolver(Request $request, Challenge $desafio)
    {
        $request->validate([
            'ganador_id' => 'required|in:' . $desafio->creator_id . ',' . $desafio->opponent_id,
        ]);

        if ($desafio->status !== 'active') {
            return back()->with('error', 'Solo se pueden resolver desafíos activos.');
        }

        DB::transaction(function () use ($request, $desafio) {
            $pozo = $desafio->challengeBets->sum('amount');
            $ganador = User::find($request->ganador_id);

            $ganador->increment('balance', $pozo);
            $ganador->transactions()->create([
                'type'        => 'ganancia',
                'amount'      => $pozo,
                'description' => "Premio desafío #{$desafio->id}",
            ]);

            $desafio->update(['status' => 'completed']);
        });

        return redirect()->route('admin.desafios.index')
            ->with('success', 'Desafío resuelto y ganancia acreditada.');
    }
}