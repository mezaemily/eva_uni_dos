<?php
// app/Http/Controllers/Admin/UsuarioController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::withCount('bets')->orderByDesc('created_at')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'balance'  => 'required|numeric|min:0',
            'role'     => 'required|in:admin,user',
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'name.min'           => 'El nombre debe tener al menos 3 caracteres.',
            'username.required'  => 'El username es obligatorio.',
            'username.unique'    => 'Ese username ya está en uso.',
            'email.required'     => 'El correo es obligatorio.',
            'email.unique'       => 'Ese correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'balance.min'        => 'El saldo no puede ser negativo.',
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

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'     => 'required|string|min:3|max:100',
            'username' => "required|string|min:3|max:50|unique:users,username,{$usuario->id}",
            'email'    => "required|email|unique:users,email,{$usuario->id}",
            'balance'  => 'required|numeric|min:0',
            'role'     => 'required|in:admin,user',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'username.unique'    => 'Ese username ya está en uso.',
            'email.unique'       => 'Ese correo ya está registrado.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $data = $request->only('name', 'username', 'email', 'balance', 'role');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

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
}
