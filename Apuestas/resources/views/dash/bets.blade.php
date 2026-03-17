@extends('dash.app')
@section('title',     'Apuestas — Admin')
@section('page-slug', 'apuestas')
@section('page-title','Apuestas')
@section('page-desc', 'todas las apuestas del sistema')

@section('content')

<div class="grid-4">
    <div class="sc y"><div class="sc-dot"></div>
        <div class="sc-label">Total</div>
        <div class="sc-value">{{ $stats['total'] }}</div>
    </div>
    <div class="sc g"><div class="sc-dot"></div>
        <div class="sc-label">Ganadas</div>
        <div class="sc-value">{{ $stats['won'] }}</div>
        <div class="sc-sub cg">+${{ number_format($stats['total_won'],2) }}</div>
    </div>
    <div class="sc r"><div class="sc-dot"></div>
        <div class="sc-label">Perdidas</div>
        <div class="sc-value">{{ $stats['lost'] }}</div>
        <div class="sc-sub cr">-${{ number_format($stats['total_lost'],2) }}</div>
    </div>
    <div class="sc b"><div class="sc-dot"></div>
        <div class="sc-label">Pendientes</div>
        <div class="sc-value">{{ $stats['pending'] }}</div>
        <div class="sc-sub cb">${{ number_format($stats['pending_amount'],2) }}</div>
    </div>
</div>

<div class="card gap">
    <div class="card-title">// todas las apuestas</div>
    <div class="tw">
        <table>
            <thead><tr>
                <th>#</th><th>Usuario</th><th>Partido</th><th>Opción</th>
                <th>Cuota</th><th>Monto</th><th>Gan. potencial</th><th>Estado</th><th>Fecha</th>
            </tr></thead>
            <tbody>
            @foreach($bets as $bet)
            <tr>
                <td class="cm">{{ $bet->id }}</td>
                <td class="cm">@{{ $bet->user->username ?? '-' }}</td>
                <td style="font-size:12px;">
                    {{ $bet->match->teamHome->name ?? '?' }}
                    <span class="vs">vs</span>
                    {{ $bet->match->teamAway->name ?? '?' }}
                </td>
                <td style="font-size:12px;color:var(--text2);">{{ $bet->odd->option_name ?? '-' }}</td>
                <td class="cy">x{{ number_format($bet->odd->odd_value ?? 0,2) }}</td>
                <td class="cr">-${{ number_format($bet->amount,2) }}</td>
                <td class="cg">+${{ number_format($bet->potential_win,2) }}</td>
                <td><span class="b {{ $bet->status }}">{{ $bet->status }}</span></td>
                <td class="cm">{{ $bet->created_at?->format('d/m H:i') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        {{ $bets->links() }}
    </div>
</div>

@endsection