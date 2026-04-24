<?php
// app/Http/Controllers/Admin/TransaccionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaccionController extends Controller
{
    /** GET /admin/crud/transacciones */
    public function index(Request $request)
    {
        $query = Transaction::with('user')->orderByDesc('created_at');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $transacciones = $query->paginate(25)->withQueryString();
        $tipos = Transaction::distinct()->pluck('type');

        return view('admin.transacciones.index', compact('transacciones', 'tipos'));
    }

    /** GET /admin/crud/transacciones/crear */
    public function create()
    {
        $usuarios = User::orderBy('username')->get(['id', 'username', 'balance']);
        $tipos    = ['deposito', 'retiro', 'bono', 'ajuste_admin'];

        return view('admin.transacciones.create', compact('usuarios', 'tipos'));
    }

    /** POST /admin/crud/transacciones */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'type'        => 'required|in:deposito,retiro,bono,ajuste_admin',
            'amount'      => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($request->user_id);

        // Para retiros verificar saldo suficiente
        if ($request->type === 'retiro' && $user->balance < $request->amount) {
            return back()->withErrors(['amount' => 'El usuario no tiene saldo suficiente para este retiro.'])->withInput();
        }

        DB::transaction(function () use ($request, $user) {
            Transaction::create([
                'user_id'     => $user->id,
                'type'        => $request->type,
                'amount'      => $request->amount,
                'description' => $request->description ?? ucfirst($request->type) . ' manual por administrador',
            ]);

            // Actualizar balance del usuario
            if (in_array($request->type, ['deposito', 'bono', 'ajuste_admin'])) {
                $user->increment('balance', $request->amount);
            } elseif ($request->type === 'retiro') {
                $user->decrement('balance', $request->amount);
            }
        });

        return redirect()->route('admin.transacciones.index')
            ->with('success', 'Transacción registrada correctamente.');
    }

    /** GET /admin/crud/transacciones/{transaccion} */
    public function show(Transaction $transaccion)
    {
        $transaccion->load('user');

        return view('admin.transacciones.show', compact('transaccion'));
    }

    /** GET /admin/crud/transacciones/{transaccion}/editar */
    public function edit(Transaction $transaccion)
    {
        $transaccion->load('user');

        return view('admin.transacciones.edit', compact('transaccion'));
    }

    /** PUT /admin/crud/transacciones/{transaccion} */
    public function update(Request $request, Transaction $transaccion)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        // Solo se permite editar la descripción; el monto y tipo son inmutables
        $transaccion->update([
            'description' => $request->description,
        ]);

        return redirect()->route('admin.transacciones.index')
            ->with('success', 'Transacción actualizada.');
    }

    /** DELETE /admin/crud/transacciones/{transaccion} */
    public function destroy(Transaction $transaccion)
    {
        // Revertir el efecto sobre el balance
        DB::transaction(function () use ($transaccion) {
            if (in_array($transaccion->type, ['deposito', 'bono', 'ajuste_admin', 'ganancia'])) {
                $transaccion->user->decrement('balance', $transaccion->amount);
            } elseif (in_array($transaccion->type, ['retiro', 'apuesta'])) {
                $transaccion->user->increment('balance', $transaccion->amount);
            }
            $transaccion->delete();
        });

        return redirect()->route('admin.transacciones.index')
            ->with('success', 'Transacción eliminada y balance revertido.');
    }

    /** GET /admin/crud/transacciones/resumen — totales por tipo */
    public function resumen()
    {
        $resumen = Transaction::selectRaw('type, COUNT(*) as total, SUM(amount) as monto_total')
            ->groupBy('type')
            ->get();

        return view('admin.transacciones.resumen', compact('resumen'));
    }
}