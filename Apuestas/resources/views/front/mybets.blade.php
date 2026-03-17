@extends('front.app')
@section('title', 'Mis Apuestas — BetArena')

@section('content')

<div style="font-family:var(--h);font-size:24px;font-weight:700;letter-spacing:1px;margin-bottom:24px;">
    🎯 Mis Apuestas
</div>

<div class="g4" style="margin-bottom:22px;">
    <div class="stat y">
        <div class="stat-label">Total</div>
        <div class="stat-val">{{ $stats['total'] }}</div>
    </div>
    <div class="stat g">
        <div class="stat-label">Ganadas</div>
        <div class="stat-val">{{ $stats['won'] }}</div>
        <div class="stat-sub cg">+${{ number_format($stats['won_amount'],2) }}</div>
    </div>
    <div class="stat r">
        <div class="stat-label">Perdidas</div>
        <div class="stat-val">{{ $stats['lost'] }}</div>
        <div class="stat-sub cr">-${{ number_format($stats['lost_amount'],2) }}</div>
    </div>
    <div class="stat b">
        <div class="stat-label">Pendientes</div>
        <div class="stat-val">{{ $stats['pending'] }}</div>
        <div class="stat-sub cb">${{ number_format($stats['pending_amount'],2) }} en juego</div>
    </div>
</div>

<div class="card">
    <div class="card-hdr">Historial completo</div>

    @if($bets->isEmpty())
        <div class="empty">No has realizado ninguna apuesta aún</div>
    @else
    <div class="tw">
        <table>
            <thead><tr>
                <th>#</th><th>Partido</th><th>Opción</th><th>Cuota</th>
                <th>Monto</th><th>Ganancia pot.</th><th>Estado</th><th>Fecha</th>
            </tr></thead>
            <tbody>
            @foreach($bets as $bet)
            <tr>
                <td class="cm">{{ $bet->id }}</td>
                <td>
                    <div style="font-size:13px;font-weight:500;">
                        {{ $bet->match->teamHome->name ?? '?' }}
                        <span class="vs">vs</span>
                        {{ $bet->match->teamAway->name ?? '?' }}
                    </div>
                    <div class="cm">{{ $bet->match->sport->name ?? '' }} · {{ $bet->match->match_date?->format('d/m/Y') }}</div>
                </td>
                <td style="font-size:12px;color:var(--text2);">{{ $bet->odd->option_name ?? '-' }}</td>
                <td class="cy">x{{ number_format($bet->odd->odd_value ?? 0,2) }}</td>
                <td class="cr">-${{ number_format($bet->amount,2) }}</td>
                <td class="cg">+${{ number_format($bet->potential_win,2) }}</td>
                <td><span class="bx {{ $bet->status }}">{{ $bet->status }}</span></td>
                <td class="cm">{{ $bet->created_at?->format('d/m H:i') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        {{ $bets->links() }}
    </div>
    @endif
</div>

@endsection