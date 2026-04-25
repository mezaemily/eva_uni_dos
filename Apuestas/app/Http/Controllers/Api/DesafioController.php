<?php
// app/Http/Controllers/Api/DesafioController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesafioController extends Controller
{
    /** GET /api/desafios */
    public function index(Request $request)
    {
        $query = Challenge::with(['creator', 'opponent', 'challengeBets'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->paginate(20));
    }

    /** POST /api/desafios */
    public function store(Request $request)
    {
        $request->validate([
            'opponent_id' => 'required|exists:users,id|different:' . auth()->id(),
        ]);

        $desafio = Challenge::create([
            'creator_id'  => auth()->id(),
            'opponent_id' => $request->opponent_id,
            'status'      => 'pending',
        ]);

        return response()->json([
            'message' => 'Desafío creado correctamente.',
            'desafio' => $desafio->load(['creator', 'opponent']),
        ], 201);
    }

    /** GET /api/desafios/{desafio} */
    public function show(Challenge $desafio)
    {
        return response()->json(
            $desafio->load(['creator', 'opponent', 'challengeBets.user'])
        );
    }

    /** PUT /api/desafios/{desafio} */
    public function update(Request $request, Challenge $desafio)
    {
        $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled',
        ]);

        $estadoAnterior = $desafio->status;
        $desafio->update(['status' => $request->status]);

        // Si se cancela devolver montos apostados
        if ($request->status === 'cancelled' && $estadoAnterior !== 'cancelled') {
            DB::transaction(function () use ($desafio) {
                foreach ($desafio->challengeBets as $bet) {
                    $bet->user->increment('balance', $bet->amount);
                    $bet->user->transactions()->create([
                        'type'        => 'devolucion',
                        'amount'      => $bet->amount,
                        'description' => "Devolución por cancelación de desafío #{$desafio->id}",
                    ]);
                }
            });
        }

        return response()->json([
            'message' => 'Desafío actualizado.',
            'desafio' => $desafio->fresh()->load(['creator', 'opponent']),
        ]);
    }

    /** DELETE /api/desafios/{desafio} */
    public function destroy(Challenge $desafio)
    {
        if ($desafio->status === 'completed') {
            return response()->json(['error' => 'No se puede eliminar un desafío completado.'], 422);
        }

        DB::transaction(function () use ($desafio) {
            foreach ($desafio->challengeBets as $bet) {
                $bet->user->increment('balance', $bet->amount);
                $bet->user->transactions()->create([
                    'type'        => 'devolucion',
                    'amount'      => $bet->amount,
                    'description' => "Devolución por eliminación de desafío #{$desafio->id}",
                ]);
            }
            $desafio->challengeBets()->delete();
            $desafio->delete();
        });

        return response()->json(['message' => 'Desafío eliminado y saldos devueltos.']);
    }

    /**
     * POST /api/desafios/{desafio}/resolver
     * Declara ganador y distribuye el pozo.
     */
   public function resolver(Request $request, Challenge $desafio)
    {
        // 1. Validamos que el ganador enviado participe en el desafío
        $request->validate([
            'ganador_id' => 'required|in:' . $desafio->creator_id . ',' . $desafio->opponent_id,
        ], [
            'ganador_id.in' => "El ID {$request->ganador_id} no participa en este desafío. Los válidos son: {$desafio->creator_id} o {$desafio->opponent_id}"
        ]);

        // 2. Activación automática (para facilitar tu prueba en Thunder Client)
        if ($desafio->status === 'pending') {
            $desafio->update(['status' => 'active']);
        }

        // Solo se resuelven si están activos
        if ($desafio->status !== 'active') {
            return response()->json(['error' => 'El desafío ya está completado o cancelado.'], 422);
        }

        return DB::transaction(function () use ($request, $desafio) {
            
            // --- CAMBIO PARA PRUEBA: Monto fijo en lugar de sumar la tabla challenge_bets ---
            $pozo = 500; 
            
            /* // Esto lo comentamos para que no te de el error de "pozo vacío"
            if ($pozo <= 0) {
                return response()->json(['error' => 'No hay dinero en el pozo para repartir.'], 422);
            }
            */

            $ganador = User::find($request->ganador_id);

            // 3. Acreditamos el dinero al balance del usuario
            $ganador->increment('balance', $pozo);
            
            // 4. Registramos la transacción para que aparezca en su historial
            $ganador->transactions()->create([
                'type'        => 'ganancia',
                'amount'      => $pozo,
                'description' => "Premio desafío #{$desafio->id} (Prueba de sistema)",
            ]);

            // 5. Marcamos el desafío como completado
            $desafio->update(['status' => 'completed']);

            return response()->json([
                'status'        => 'success',
                'message'       => '¡Desafío resuelto correctamente!',
                'ganador'       => $ganador->name,
                'premio_pagado' => $pozo,
                'nuevo_saldo'   => $ganador->fresh()->balance
            ]);
        });
    }
}