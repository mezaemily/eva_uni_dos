@extends('dash.app')
@section('title',     'Transacciones — Admin')
@section('page-slug', 'transacciones')
@section('page-title','Transacciones')
@section('page-desc', 'todos los movimientos financieros')

@section('content')

<div class="grid-3">
    <div class="sc g"><div class="sc-dot"></div>
        <div class="sc-label">Depósitos totales</div>
        <div class="sc-value">${{ number_format($stats['deposits'],2) }}</div>
    </div>
    <div class="sc r"><div class="sc-dot"></div>
        <div class="sc-label">Retiros totales</div>
        <div class="sc-value">${{ number_format($stats['withdrawals'],2) }}</div>
    </div>
    <div class="sc b"><div class="sc-dot"></div>
        <div class="sc-label">Ganancias pagadas</div>
        <div class="sc-value">${{ number_format($stats['bet_wins'],2) }}</div>
    </div>
</div>

<div class="card gap">
    <div class="card-title">// historial completo</div>
    <div class="tw">
        <table>
            <thead><tr>
                <th>#</th><th>Usuario</th><th>Tipo</th><th>Monto</th>
                <th>Descripción</th><th>Fecha</th>
            </tr></thead>
            <tbody>
            @foreach($transactions as $tx)
            <tr>
                <td class="cm">{{ $tx->id }}</td>
                <td class="cm">@{{ $tx->user->username ?? '-' }}</td>
                <td><span class="b {{ $tx->type }}">{{ str_replace('_',' ',$tx->type) }}</span></td>
                <td class="{{ in_array($tx->type,['deposit','bet_win']) ? 'cg' : 'cr' }}">
                    {{ in_array($tx->type,['deposit','bet_win']) ? '+' : '-' }}${{ number_format($tx->amount,2) }}
                </td>
                <td style="font-size:12px;color:var(--text2);">{{ Str::limit($tx->description,40) ?? '—' }}</td>
                <td class="cm">{{ $tx->created_at?->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        {{ $transactions->links() }}
    </div>
</div>

@endsection