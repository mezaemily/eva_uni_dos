<?php
// app/Http/Controllers/Api/UsuarioController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * API REST de Usuarios — protegida con JWT.
 *
 * Rutas sugeridas (api.php):
 *   GET    /api/usuarios          → index
 *   POST   /api/usuarios          → store
 *   GET    /api/usuarios/{id}     → show
 *   PUT    /api/usuarios/{id}     → update
 *   DELETE /api/usuarios/{id}     → destroy
 */
class UsuarioController extends Controller
{
    /** GET /api/usuarios */
    public function index()
    {
        $usuarios = User::withCount('bets')
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($usuarios);
    }

    /** POST /api/usuarios */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:50|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'balance'  => 'sometimes|numeric|min:0',
            'role'     => 'sometimes|in:admin,user',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'balance'  => $request->balance ?? 0,
            'role'     => $request->role ?? 'user',
        ]);

        return response()->json(['message' => 'Usuario creado', 'user' => $user], 201);
    }

    /** GET /api/usuarios/{id} */
    public function show(User $usuario)
    {
        $usuario->loadCount(['bets', 'transactions']);

        return response()->json($usuario);
    }

    /** PUT /api/usuarios/{id} */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'     => 'sometimes|string|min:3|max:100',
            'username' => "sometimes|string|min:3|max:50|unique:users,username,{$usuario->id}",
            'email'    => "sometimes|email|unique:users,email,{$usuario->id}",
            'balance'  => 'sometimes|numeric|min:0',
            'role'     => 'sometimes|in:admin,user',
            'password' => 'sometimes|string|min:8',
        ]);

        $data = $request->only('name', 'username', 'email', 'balance', 'role');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return response()->json(['message' => 'Usuario actualizado', 'user' => $usuario]);
    }

    /** DELETE /api/usuarios/{id} */
    public function destroy(User $usuario)
    {
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}