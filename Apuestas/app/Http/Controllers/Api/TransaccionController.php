<?php
// app/Http/Controllers/Api/TransaccionController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * API REST de Transacciones / Pagos.
 *
 * Rutas sugeridas (api.php, middleware jwt):
 *   GET    /api/transacciones          → index   (mis transacciones)
 *   POST   /api/transacciones/deposito → deposito
 *   POST   /api/transacciones/retiro   → retiro
 *   GET    /api/transacciones/{id}     → show
 */
class TransaccionController extends Controller
{
    /** GET /api/transacciones — Historial del usuario autenticado */
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())
            ->orderByDesc('created_at');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return response()->json($query->paginate(25));
    }

    /** GET /api/transacciones/{id} */
    public function show(Transaction $transaccion)
    {
        if ($transaccion->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        return response()->json($transaccion);
    }

    /**
     * POST /api/transacciones/deposito
     * Simula un depósito de saldo (en producción se integraría con pasarela de pago).
     */
    public function deposito(Request $request)
    {
        $request->validate([
            'amount'      => 'required|numeric|min:10',
            'description' => 'nullable|string|max:255',
        ]);

        $user        = auth()->user();
        $transaction = DB::transaction(function () use ($request, $user) {
            $user->increment('balance', $request->amount);

            return $user->transactions()->create([
                'type'        => 'deposito',
                'amount'      => $request->amount,
                'description' => $request->description ?? 'Depósito de saldo',
            ]);
        });

        return response()->json([
            'message'     => 'Depósito realizado.',
            'transaction' => $transaction,
            'balance'     => $user->fresh()->balance,
        ], 201);
    }

    /**
     * POST /api/transacciones/retiro
     * Solicita retiro de saldo.
     */
    public function retiro(Request $request)
    {
        $request->validate([
            'amount'      => 'required|numeric|min:10',
            'description' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        if ($user->balance < $request->amount) {
            return response()->json(['error' => 'Saldo insuficiente.'], 422);
        }

        $transaction = DB::transaction(function () use ($request, $user) {
            $user->decrement('balance', $request->amount);

            return $user->transactions()->create([
                'type'        => 'retiro',
                'amount'      => $request->amount,
                'description' => $request->description ?? 'Retiro de saldo',
            ]);
        });

        return response()->json([
            'message'     => 'Retiro procesado.',
            'transaction' => $transaction,
            'balance'     => $user->fresh()->balance,
        ]);
    }

    /** GET /api/transacciones/saldo — Saldo actual */
    public function saldo()
    {
        return response()->json([
            'balance' => auth()->user()->balance,
        ]);
    }
}