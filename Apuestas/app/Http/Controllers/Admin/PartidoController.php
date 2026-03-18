<?php
// app/Http/Controllers/Admin/PartidoController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameMatch;
use App\Models\Sport;
use App\Models\Team;
use Illuminate\Http\Request;

class PartidoController extends Controller
{
    public function index()
    {
        $partidos = GameMatch::with(['sport', 'teamHome', 'teamAway'])
            ->withCount('bets')
            ->orderByDesc('match_date')
            ->paginate(15);
        return view('admin.partidos.index', compact('partidos'));
    }

    public function create()
    {
        $deportes = Sport::orderBy('name')->get();
        $equipos  = Team::with('sport')->orderBy('name')->get();
        return view('admin.partidos.create', compact('deportes', 'equipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sport_id'     => 'required|exists:sports,id',
            'team_home_id' => 'required|exists:teams,id',
            'team_away_id' => 'required|exists:teams,id|different:team_home_id',
            'match_date'   => 'required|date',
            'status'       => 'required|in:scheduled,live,finished,cancelled',
        ], [
            'sport_id.required'      => 'Debes seleccionar un deporte.',
            'team_home_id.required'  => 'Debes seleccionar el equipo local.',
            'team_away_id.required'  => 'Debes seleccionar el equipo visitante.',
            'team_away_id.different' => 'El equipo visitante debe ser diferente al local.',
            'match_date.required'    => 'La fecha del partido es obligatoria.',
            'match_date.date'        => 'La fecha no es válida.',
            'status.required'        => 'El estado es obligatorio.',
        ]);

        GameMatch::create($request->only(
            'sport_id', 'team_home_id', 'team_away_id', 'match_date', 'status'
        ));

        return redirect()->route('admin.partidos.index')
            ->with('success', 'Partido creado correctamente.');
    }

    public function edit(GameMatch $partido)
    {
        $deportes = Sport::orderBy('name')->get();
        $equipos  = Team::with('sport')->orderBy('name')->get();
        return view('admin.partidos.edit', compact('partido', 'deportes', 'equipos'));
    }

    public function update(Request $request, GameMatch $partido)
    {
        $request->validate([
            'sport_id'     => 'required|exists:sports,id',
            'team_home_id' => 'required|exists:teams,id',
            'team_away_id' => 'required|exists:teams,id|different:team_home_id',
            'match_date'   => 'required|date',
            'home_score'   => 'nullable|integer|min:0',
            'away_score'   => 'nullable|integer|min:0',
            'status'       => 'required|in:scheduled,live,finished,cancelled',
        ], [
            'sport_id.required'      => 'Debes seleccionar un deporte.',
            'team_home_id.required'  => 'Debes seleccionar el equipo local.',
            'team_away_id.required'  => 'Debes seleccionar el equipo visitante.',
            'team_away_id.different' => 'El equipo visitante debe ser diferente al local.',
            'match_date.required'    => 'La fecha del partido es obligatoria.',
            'home_score.integer'     => 'El marcador debe ser un número entero.',
            'away_score.integer'     => 'El marcador debe ser un número entero.',
        ]);

        $partido->update($request->only(
            'sport_id', 'team_home_id', 'team_away_id',
            'match_date', 'home_score', 'away_score', 'status'
        ));

        return redirect()->route('admin.partidos.index')
            ->with('success', 'Partido actualizado correctamente.');
    }

    public function destroy(GameMatch $partido)
    {
        $partido->delete();

        return redirect()->route('admin.partidos.index')
            ->with('success', 'Partido eliminado correctamente.');
    }
}
