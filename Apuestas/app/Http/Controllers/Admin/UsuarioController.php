<?php
// app/Http/Controllers/Admin/UsuarioController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /** GET /admin/crud/usuarios */
    public function index()
    {
        $usuarios = User::withCount('bets')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    /** GET /admin/crud/usuarios/crear */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /** POST /admin/crud/usuarios */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'balance'  => 'required|numeric|min:0',
            'role'     => 'required|in:admin,user',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'balance'  => $request->balance,
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /** GET /admin/crud/usuarios/{usuario} */
    public function show(User $usuario)
    {
        $usuario->loadCount(['bets', 'transactions']);
        $usuario->load(['bets' => fn($q) => $q->latest()->limit(10)]);

        return view('admin.usuarios.show', compact('usuario'));
    }

    /** GET /admin/crud/usuarios/{usuario}/editar */
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /** PUT /admin/crud/usuarios/{usuario} */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'     => 'required|string|min:3|max:100',
            'username' => "required|string|min:3|max:50|unique:users,username,{$usuario->id}",
            'email'    => "required|email|unique:users,email,{$usuario->id}",
            'balance'  => 'required|numeric|min:0',
            'role'     => 'required|in:admin,user',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only('name', 'username', 'email', 'balance', 'role');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /** DELETE /admin/crud/usuarios/{usuario} */
    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    /** PATCH /admin/crud/usuarios/{usuario}/saldo — ajustar saldo manualmente */
    public function ajustarSaldo(Request $request, User $usuario)
    {
        $request->validate([
            'monto'       => 'required|numeric',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $usuario->increment('balance', $request->monto);

        $usuario->transactions()->create([
            'type'        => $request->monto >= 0 ? 'deposito_admin' : 'retiro_admin',
            'amount'      => abs($request->monto),
            'description' => $request->descripcion ?? 'Ajuste manual por administrador',
        ]);

        return redirect()->back()
            ->with('success', 'Saldo ajustado correctamente.');
    }
}