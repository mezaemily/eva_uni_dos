<?php
// app/Http/Controllers/Api/CuotaController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Odd;
use App\Models\BetType;
use App\Models\GameMatch;
use Illuminate\Http\Request;

class CuotaController extends Controller
{
    /** GET /api/cuotas */
    public function index(Request $request)
    {
        $query = Odd::with(['match.teamHome', 'match.teamAway', 'betType'])
            ->orderByDesc('created_at');

        if ($request->filled('match_id')) {
            $query->where('match_id', $request->match_id);
        }

        if ($request->filled('bet_type_id')) {
            $query->where('bet_type_id', $request->bet_type_id);
        }

        return response()->json($query->paginate(25));
    }

    /** POST /api/cuotas */
    public function store(Request $request)
    {
        $request->validate([
            'match_id'    => 'required|exists:matches,id',
            'bet_type_id' => 'required|exists:bet_types,id',
            'option_name' => 'required|string|max:100',
            'odd_value'   => 'required|numeric|min:1.01',
        ]);

        $cuota = Odd::create($request->only('match_id', 'bet_type_id', 'option_name', 'odd_value'));

        return response()->json([
            'message' => 'Cuota creada correctamente.',
            'cuota'   => $cuota->load(['match.teamHome', 'match.teamAway', 'betType']),
        ], 201);
    }

    /** GET /api/cuotas/{cuota} */
    public function show(Odd $cuota)
    {
        return response()->json(
            $cuota->load(['match.teamHome', 'match.teamAway', 'betType'])
        );
    }

    /** PUT /api/cuotas/{cuota} */
    public function update(Request $request, Odd $cuota)
    {
        $request->validate([
            'option_name' => 'sometimes|string|max:100',
            'odd_value'   => 'sometimes|numeric|min:1.01',
        ]);

        $cuota->update($request->only('option_name', 'odd_value'));

        return response()->json([
            'message' => 'Cuota actualizada.',
            'cuota'   => $cuota->fresh()->load('betType'),
        ]);
    }

    /** DELETE /api/cuotas/{cuota} */
    public function destroy(Odd $cuota)
    {
        if ($cuota->bets()->where('status', 'pending')->exists()) {
            return response()->json([
                'error' => 'No se puede eliminar: existen apuestas pendientes con esta cuota.',
            ], 422);
        }

        $cuota->delete();

        return response()->json(['message' => 'Cuota eliminada correctamente.']);
    }
}