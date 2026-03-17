@extends('dash.app')
@section('title',     'Minas — Admin')
@section('page-slug', 'minas')
@section('page-title','Minas')
@section('page-desc', 'partidas del juego de minas')

@section('content')

<div class="grid-4">
    <div class="sc y"><div class="sc-dot"></div>
        <div class="sc-label">Total partidas</div>
        <div class="sc-value">{{ $stats['total'] }}</div>
    </div>
    <div class="sc g"><div class="sc-dot"></div>
        <div class="sc-label">Ganadas</div>
        <div class="sc-value">{{ $stats['won'] }}</div>
        <div class="sc-sub cg">+${{ number_format($stats['total_winnings'],2) }}</div>
    </div>
    <div class="sc r"><div class="sc-dot"></div>
        <div class="sc-label">Perdidas</div>
        <div class="sc-value">{{ $stats['lost'] }}</div>
        <div class="sc-sub cr">-${{ number_format($stats['total_lost'],2) }}</div>
    </div>
    <div class="sc b"><div class="sc-dot"></div>
        <div class="sc-label">En juego</div>
        <div class="sc-value">{{ $stats['playing'] }}</div>
        <div class="sc-sub cb">${{ number_format($stats['in_play'],2) }}</div>
    </div>
</div>

<div class="card gap">
    <div class="card-title">// historial de partidas</div>
    <div class="tw">
        <table>
            <thead><tr>
                <th>#</th><th>Usuario</th><th>Apuesta</th><th>Minas</th>
                <th>Multiplicador</th><th>Ganancias</th><th>Estado</th><th>Fecha</th>
            </tr></thead>
            <tbody>
            @foreach($games as $g)
            <tr>
                <td class="cm">{{ $g->id }}</td>
                <td class="cm">@{{ $g->user->username ?? '-' }}</td>
                <td class="cr">-${{ number_format($g->bet_amount,2) }}</td>
                <td class="cy">{{ $g->mines }}</td>
                <td class="cy">x{{ number_format($g->multiplier,2) }}</td>
                <td>
                    @if($g->status === 'won')
                        <span class="cg">+${{ number_format($g->winnings,2) }}</span>
                    @elseif($g->status === 'lost')
                        <span class="cr">$0.00</span>
                    @else
                        <span class="cm">—</span>
                    @endif
                </td>
                <td><span class="b {{ $g->status }}">{{ $g->status }}</span></td>
                <td class="cm">{{ $g->created_at?->format('d/m H:i') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        {{ $games->links() }}
    </div>
</div>

@endsection