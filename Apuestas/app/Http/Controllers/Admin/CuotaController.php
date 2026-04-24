<?php
// app/Http/Controllers/Admin/CuotaController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Odd;
use App\Models\BetType;
use App\Models\GameMatch;
use Illuminate\Http\Request;

class CuotaController extends Controller
{
    /** GET /admin/crud/cuotas */
    public function index(Request $request)
    {
        $query = Odd::with(['match.teamHome', 'match.teamAway', 'betType'])
            ->orderByDesc('created_at');

        if ($request->filled('match_id')) {
            $query->where('match_id', $request->match_id);
        }

        $cuotas  = $query->paginate(25)->withQueryString();
        $partidos = GameMatch::with(['teamHome', 'teamAway'])->orderByDesc('match_date')->limit(50)->get();

        return view('admin.cuotas.index', compact('cuotas', 'partidos'));
    }

    /** GET /admin/crud/cuotas/crear */
    public function create()
    {
        $partidos  = GameMatch::with(['teamHome', 'teamAway'])->where('status', 'scheduled')->orderBy('match_date')->get();
        $betTypes  = BetType::orderBy('name')->get();

        return view('admin.cuotas.create', compact('partidos', 'betTypes'));
    }

    /** POST /admin/crud/cuotas */
    public function store(Request $request)
    {
        $request->validate([
            'match_id'    => 'required|exists:matches,id',
            'bet_type_id' => 'required|exists:bet_types,id',
            'option_name' => 'required|string|max:100',
            'odd_value'   => 'required|numeric|min:1.01',
        ]);

        Odd::create($request->only('match_id', 'bet_type_id', 'option_name', 'odd_value'));

        return redirect()->route('admin.cuotas.index')
            ->with('success', 'Cuota creada correctamente.');
    }

    /** GET /admin/crud/cuotas/{cuota} */
    public function show(Odd $cuota)
    {
        $cuota->load(['match.teamHome', 'match.teamAway', 'betType', 'bets.user']);

        return view('admin.cuotas.show', compact('cuota'));
    }

    /** GET /admin/crud/cuotas/{cuota}/editar */
    public function edit(Odd $cuota)
    {
        $partidos = GameMatch::with(['teamHome', 'teamAway'])->orderByDesc('match_date')->get();
        $betTypes = BetType::orderBy('name')->get();

        return view('admin.cuotas.edit', compact('cuota', 'partidos', 'betTypes'));
    }

    /** PUT /admin/crud/cuotas/{cuota} */
    public function update(Request $request, Odd $cuota)
    {
        $request->validate([
            'option_name' => 'required|string|max:100',
            'odd_value'   => 'required|numeric|min:1.01',
        ]);

        $cuota->update($request->only('option_name', 'odd_value'));

        return redirect()->route('admin.cuotas.index')
            ->with('success', 'Cuota actualizada correctamente.');
    }

    /** DELETE /admin/crud/cuotas/{cuota} */
    public function destroy(Odd $cuota)
    {
        if ($cuota->bets()->where('status', 'pending')->exists()) {
            return back()->with('error', 'No se puede eliminar: existen apuestas pendientes con esta cuota.');
        }

        $cuota->delete();

        return redirect()->route('admin.cuotas.index')
            ->with('success', 'Cuota eliminada correctamente.');
    }
}