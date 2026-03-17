@extends('dash.app')
@section('title',     'Resumen — Admin')
@section('page-slug', 'index')
@section('page-title','Resumen general')
@section('page-desc', 'Vista agregada del sistema')

@section('content')

{{-- KPIs --}}
<div class="grid-4">
    <div class="sc y">
        <div class="sc-dot"></div>
        <div class="sc-label">Usuarios totales</div>
        <div class="sc-value">{{ $totalUsers }}</div>
        <div class="sc-sub cy">{{ $newUsersToday }} hoy</div>
    </div>
    <div class="sc g">
        <div class="sc-dot"></div>
        <div class="sc-label">Apuestas activas</div>
        <div class="sc-value">{{ $pendingBets }}</div>
        <div class="sc-sub cg">de {{ $totalBets }} totales</div>
    </div>
    <div class="sc b">
        <div class="sc-dot"></div>
        <div class="sc-label">Partidos programados</div>
        <div class="sc-value">{{ $scheduledMatches }}</div>
        <div class="sc-sub cb">{{ $finishedMatches }} finalizados</div>
    </div>
    <div class="sc r">
        <div class="sc-dot"></div>
        <div class="sc-label">Saldo en sistema</div>
        <div class="sc-value">${{ number_format($totalBalance, 0) }}</div>
        <div class="sc-sub cr">{{ $totalTransactions }} movimientos</div>
    </div>
</div>

<div class="grid-2 gap">

    {{-- Últimas apuestas --}}
    <div class="card">
        <div class="card-title">// apuestas recientes</div>
        @if($recentBets->isEmpty())
            <div class="empty">sin_datos</div>
        @else
        <div class="tw">
            <table>
                <thead><tr>
                    <th>Usuario</th><th>Partido</th><th>Monto</th><th>Estado</th>
                </tr></thead>
                <tbody>
                @foreach($recentBets as $bet)
                <tr>
                    <td class="cm">{{ $bet->user->username ?? '-' }}</td>
                    <td style="font-size:12px;">
                        {{ $bet->match->teamHome->name ?? '?' }}
                        <span class="vs">vs</span>
                        {{ $bet->match->teamAway->name ?? '?' }}
                    </td>
                    <td class="cr">-${{ number_format($bet->amount,2) }}</td>
                    <td><span class="b {{ $bet->status }}">{{ $bet->status }}</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Últimas transacciones --}}
    <div class="card">
        <div class="card-title">// transacciones recientes</div>
        @if($recentTransactions->isEmpty())
            <div class="empty">sin_datos</div>
        @else
        <div class="tw">
            <table>
                <thead><tr>
                    <th>Usuario</th><th>Tipo</th><th>Monto</th><th>Fecha</th>
                </tr></thead>
                <tbody>
                @foreach($recentTransactions as $tx)
                <tr>
                    <td class="cm">{{ $tx->user->username ?? '-' }}</td>
                    <td><span class="b {{ $tx->type }}">{{ str_replace('_',' ',$tx->type) }}</span></td>
                    <td class="{{ in_array($tx->type,['deposit','bet_win']) ? 'cg' : 'cr' }}">
                        {{ in_array($tx->type,['deposit','bet_win']) ? '+' : '-' }}${{ number_format($tx->amount,2) }}
                    </td>
                    <td class="cm">{{ $tx->created_at?->format('d/m H:i') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

<div class="grid-2 gap">

    {{-- Partidos próximos --}}
    <div class="card">
        <div class="card-title">// próximos partidos</div>
        @if($nextMatches->isEmpty())
            <div class="empty">sin_datos</div>
        @else
        <div class="tw">
            <table>
                <thead><tr>
                    <th>Deporte</th><th>Partido</th><th>Fecha</th><th>Estado</th>
                </tr></thead>
                <tbody>
                @foreach($nextMatches as $m)
                <tr>
                    <td class="cm">{{ $m->sport->name ?? '-' }}</td>
                    <td style="font-size:12px;">
                        <strong>{{ $m->teamHome->name }}</strong>
                        <span class="vs">vs</span>
                        <strong>{{ $m->teamAway->name }}</strong>
                    </td>
                    <td class="cm">{{ $m->match_date?->format('d/m H:i') }}</td>
                    <td><span class="b {{ $m->status }}">{{ $m->status }}</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Mine games resumen --}}
    <div class="card">
        <div class="card-title">// minas — actividad reciente</div>
        @if($recentMines->isEmpty())
            <div class="empty">sin_datos</div>
        @else
        <div class="tw">
            <table>
                <thead><tr>
                    <th>Usuario</th><th>Apuesta</th><th>Minas</th><th>Estado</th>
                </tr></thead>
                <tbody>
                @foreach($recentMines as $g)
                <tr>
                    <td class="cm">{{ $g->user->username ?? '-' }}</td>
                    <td class="cr">${{ number_format($g->bet_amount,2) }}</td>
                    <td class="cy">{{ $g->mines }}</td>
                    <td><span class="b {{ $g->status }}">{{ $g->status }}</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection