<?php
// app/Http/Controllers/Api/ApuestaController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\Odd;
use App\Models\GameMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * API REST de Apuestas (Comprar / Vender / Subastar).
 *
 * Rutas sugeridas (api.php, middleware jwt):
 *   GET    /api/apuestas          → index   (mis apuestas)
 *   POST   /api/apuestas          → store   (COMPRAR / colocar apuesta)
 *   GET    /api/apuestas/{id}     → show
 *   DELETE /api/apuestas/{id}     → destroy (VENDER / cancelar antes del partido)
 *   POST   /api/apuestas/subasta  → subasta (pujar en mercado de apuestas)
 */
class ApuestaController extends Controller
{
    /** GET /api/apuestas — Listar apuestas del usuario autenticado */
    public function index(Request $request)
    {
        $apuestas = Bet::with(['match.teamHome', 'match.teamAway', 'odd.betType'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($apuestas);
    }

    /**
     * POST /api/apuestas — COMPRAR (colocar una apuesta)
     * El usuario "compra" una posición apostando en una cuota.
     */
    public function store(Request $request)
    {
        $request->validate([
            'odd_id' => 'required|exists:odds,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();
        $odd  = Odd::with('match')->findOrFail($request->odd_id);

        if ($odd->match->status !== 'scheduled') {
            return response()->json(['error' => 'El partido ya no acepta apuestas.'], 422);
        }

        if ($user->balance < $request->amount) {
            return response()->json(['error' => 'Saldo insuficiente.'], 422);
        }

        $bet = DB::transaction(function () use ($request, $user, $odd) {
            $bet = Bet::create([
                'user_id'       => $user->id,
                'match_id'      => $odd->match_id,
                'odd_id'        => $odd->id,
                'amount'        => $request->amount,
                'potential_win' => round($request->amount * $odd->odd_value, 2),
                'status'        => 'pending',
            ]);

            $user->decrement('balance', $request->amount);

            $user->transactions()->create([
                'type'        => 'apuesta',
                'amount'      => $request->amount,
                'description' => "Apuesta #{$bet->id} — {$odd->option_name}",
            ]);

            return $bet;
        });

        return response()->json([
            'message'       => 'Apuesta colocada correctamente.',
            'bet'           => $bet->load('odd.betType'),
            'balance'       => $user->fresh()->balance,
        ], 201);
    }

    /** GET /api/apuestas/{id} */
    public function show(Bet $apuesta)
    {
        if ($apuesta->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        return response()->json($apuesta->load(['match.teamHome', 'match.teamAway', 'odd.betType']));
    }

    /**
     * DELETE /api/apuestas/{id} — VENDER (cancelar / retirar apuesta)
     * Solo antes de que comience el partido y con penalización configurable.
     */
    public function destroy(Bet $apuesta)
    {
        if ($apuesta->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        if ($apuesta->status !== 'pending') {
            return response()->json(['error' => 'Solo puedes cancelar apuestas pendientes.'], 422);
        }

        if ($apuesta->match->status !== 'scheduled') {
            return response()->json(['error' => 'El partido ya inició, no puedes retirar la apuesta.'], 422);
        }

        // Penalización del 5% por venta anticipada
        $penalizacion  = round($apuesta->amount * 0.05, 2);
        $devolucion    = $apuesta->amount - $penalizacion;

        DB::transaction(function () use ($apuesta, $devolucion, $penalizacion) {
            $apuesta->user->increment('balance', $devolucion);
            $apuesta->user->transactions()->create([
                'type'        => 'devolucion',
                'amount'      => $devolucion,
                'description' => "Venta anticipada de apuesta #{$apuesta->id} (penalización: \${$penalizacion})",
            ]);
            $apuesta->update(['status' => 'cancelled']);
        });

        return response()->json([
            'message'      => 'Apuesta cancelada.',
            'devolucion'   => $devolucion,
            'penalizacion' => $penalizacion,
            'balance'      => $apuesta->user->fresh()->balance,
        ]);
    }

    /**
     * POST /api/apuestas/subasta — SUBASTAR (mercado de apuestas P2P)
     * El apostador vende su apuesta a otro usuario al precio que defina.
     *
     * Body: { bet_id, precio_venta }
     * El comprador llama con: { subasta_id, aceptar: true }
     */
    public function subasta(Request $request)
    {
        $request->validate([
            'bet_id'       => 'required_without:subasta_id|exists:bets,id',
            'precio_venta' => 'required_without:subasta_id|numeric|min:0.01',
            'subasta_id'   => 'required_without:bet_id|exists:bets,id',
            'aceptar'      => 'required_without:bet_id|boolean',
        ]);

        // — PUBLICAR subasta (vendedor) —
        if ($request->filled('bet_id')) {
            $apuesta = Bet::findOrFail($request->bet_id);

            if ($apuesta->user_id !== auth()->id()) {
                return response()->json(['error' => 'No autorizado.'], 403);
            }

            if ($apuesta->status !== 'pending') {
                return response()->json(['error' => 'Solo se pueden subastar apuestas pendientes.'], 422);
            }

            // Marcar como "en subasta" añadiendo metadata (campo description de transaction o columna nueva)
            // Por compatibilidad con el esquema actual, usamos una transacción de tipo "subasta_publicada"
            $apuesta->user->transactions()->create([
                'type'        => 'subasta_publicada',
                'amount'      => $request->precio_venta,
                'description' => "Subasta de apuesta #{$apuesta->id} a precio \${$request->precio_venta}",
            ]);

            return response()->json([
                'message'      => 'Apuesta publicada en subasta.',
                'apuesta_id'   => $apuesta->id,
                'precio_venta' => $request->precio_venta,
            ]);
        }

        // — ACEPTAR subasta (comprador) —
        $apuesta  = Bet::with('user')->findOrFail($request->subasta_id);
        $comprador = auth()->user();

        // Buscar precio de subasta en transacciones
        $subastaInfo = $apuesta->user->transactions()
            ->where('type', 'subasta_publicada')
            ->where('description', 'like', "%#{$apuesta->id}%")
            ->latest()
            ->first();

        if (!$subastaInfo) {
            return response()->json(['error' => 'Esta apuesta no está en subasta.'], 422);
        }

        $precio = $subastaInfo->amount;

        if ($comprador->balance < $precio) {
            return response()->json(['error' => 'Saldo insuficiente para comprar esta apuesta.'], 422);
        }

        DB::transaction(function () use ($apuesta, $comprador, $precio, $subastaInfo) {
            $vendedor = $apuesta->user;

            // Transferencia del precio de comprador al vendedor
            $comprador->decrement('balance', $precio);
            $vendedor->increment('balance', $precio);

            // Transferir propiedad de la apuesta
            $apuesta->update(['user_id' => $comprador->id]);

            // Registrar transacciones
            $comprador->transactions()->create([
                'type'        => 'compra_apuesta',
                'amount'      => $precio,
                'description' => "Compra de apuesta #{$apuesta->id} en subasta",
            ]);
            $vendedor->transactions()->create([
                'type'        => 'venta_apuesta',
                'amount'      => $precio,
                'description' => "Venta de apuesta #{$apuesta->id} en subasta",
            ]);

            // Eliminar la transacción de subasta publicada
            $subastaInfo->delete();
        });

        return response()->json([
            'message'  => 'Apuesta comprada correctamente.',
            'apuesta'  => $apuesta->fresh()->load('odd.betType'),
            'balance'  => $comprador->fresh()->balance,
        ]);
    }
}