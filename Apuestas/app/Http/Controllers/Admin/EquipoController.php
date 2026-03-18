<?php
// app/Http/Controllers/Admin/EquipoController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Sport;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Team::with('sport')->orderBy('name')->paginate(15);
        return view('admin.equipos.index', compact('equipos'));
    }

    public function create()
    {
        $deportes = Sport::orderBy('name')->get();
        return view('admin.equipos.create', compact('deportes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'name'     => 'required|string|min:2|max:100',
            'strength' => 'required|integer|min:1|max:100',
        ], [
            'sport_id.required' => 'Debes seleccionar un deporte.',
            'sport_id.exists'   => 'El deporte seleccionado no es válido.',
            'name.required'     => 'El nombre del equipo es obligatorio.',
            'name.min'          => 'El nombre debe tener al menos 2 caracteres.',
            'strength.required' => 'La fortaleza es obligatoria.',
            'strength.min'      => 'La fortaleza mínima es 1.',
            'strength.max'      => 'La fortaleza máxima es 100.',
        ]);

        Team::create($request->only('sport_id', 'name', 'strength'));

        return redirect()->route('admin.equipos.index')
            ->with('success', 'Equipo creado correctamente.');
    }

    public function edit(Team $equipo)
    {
        $deportes = Sport::orderBy('name')->get();
        return view('admin.equipos.edit', compact('equipo', 'deportes'));
    }

    public function update(Request $request, Team $equipo)
    {
        $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'name'     => 'required|string|min:2|max:100',
            'strength' => 'required|integer|min:1|max:100',
        ], [
            'sport_id.required' => 'Debes seleccionar un deporte.',
            'name.required'     => 'El nombre del equipo es obligatorio.',
            'strength.required' => 'La fortaleza es obligatoria.',
            'strength.min'      => 'La fortaleza mínima es 1.',
            'strength.max'      => 'La fortaleza máxima es 100.',
        ]);

        $equipo->update($request->only('sport_id', 'name', 'strength'));

        return redirect()->route('admin.equipos.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Team $equipo)
    {
        $equipo->delete();

        return redirect()->route('admin.equipos.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}
