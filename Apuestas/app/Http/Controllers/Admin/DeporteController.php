<?php
// app/Http/Controllers/Admin/DeporteController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use Illuminate\Http\Request;

class DeporteController extends Controller
{
    public function index()
    {
        $deportes = Sport::withCount('teams')->orderBy('name')->paginate(15);
        return view('admin.deportes.index', compact('deportes'));
    }

    public function create()
    {
        return view('admin.deportes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100|unique:sports,name',
        ], [
            'name.required' => 'El nombre del deporte es obligatorio.',
            'name.min'      => 'El nombre debe tener al menos 2 caracteres.',
            'name.unique'   => 'Ya existe un deporte con ese nombre.',
        ]);

        Sport::create(['name' => $request->name]);

        return redirect()->route('admin.deportes.index')
            ->with('success', 'Deporte creado correctamente.');
    }

    public function edit(Sport $deporte)
    {
        return view('admin.deportes.edit', compact('deporte'));
    }

    public function update(Request $request, Sport $deporte)
    {
        $request->validate([
            'name' => "required|string|min:2|max:100|unique:sports,name,{$deporte->id}",
        ], [
            'name.required' => 'El nombre del deporte es obligatorio.',
            'name.min'      => 'El nombre debe tener al menos 2 caracteres.',
            'name.unique'   => 'Ya existe un deporte con ese nombre.',
        ]);

        $deporte->update(['name' => $request->name]);

        return redirect()->route('admin.deportes.index')
            ->with('success', 'Deporte actualizado correctamente.');
    }

    public function destroy(Sport $deporte)
    {
        if ($deporte->teams()->count() > 0) {
            return redirect()->route('admin.deportes.index')
                ->with('error', 'No puedes eliminar un deporte que tiene equipos asignados.');
        }

        $deporte->delete();

        return redirect()->route('admin.deportes.index')
            ->with('success', 'Deporte eliminado correctamente.');
    }
}
