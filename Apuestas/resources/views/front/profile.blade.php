@extends('front.app')
@section('title', 'Perfil — BetArena')

@section('content')

<div style="font-family:var(--h);font-size:24px;font-weight:700;letter-spacing:1px;margin-bottom:24px;">
    👤 Mi Perfil
</div>

<div class="g2">

    {{-- Profile card --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

        <div class="card" style="display:flex;align-items:center;gap:18px;">
            <div style="width:64px;height:64px;flex-shrink:0;
                background:linear-gradient(135deg,var(--gold2),var(--gold));
                border-radius:50%;display:flex;align-items:center;justify-content:center;
                font-family:var(--h);font-size:30px;font-weight:700;color:#000;
                box-shadow:0 0 24px rgba(240,192,64,.25);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-family:var(--h);font-size:22px;font-weight:700;letter-spacing:.5px;">
                    {{ auth()->user()->name }}
                </div>
                <div style="font-size:13px;color:var(--text2);">@{{ auth()->user()->username }}</div>
                <div style="font-size:12px;color:var(--muted2);margin-top:4px;">
                    {{ auth()->user()->email }}
                </div>
                <div style="margin-top:8px;">
                    <span class="bx {{ auth()->user()->role }}">{{ auth()->user()->role }}</span>
                </div>
            </div>
        </div>

        <div class="g2" style="gap:10px;">
            <div class="stat y">
                <div class="stat-label">Saldo</div>
                <div class="stat-val">${{ number_format(auth()->user()->balance,2) }}</div>
            </div>
            <div class="stat g">
                <div class="stat-label">Miembro desde</div>
                <div style="font-family:var(--h);font-size:18px;font-weight:700;color:var(--green);">
                    {{ auth()->user()->created_at?->format('M Y') }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-hdr">Estadísticas</div>
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">
                @php $u = auth()->user(); @endphp
                <div style="background:var(--bg3);border:1px solid var(--border2);border-radius:8px;padding:12px;">
                    <div style="font-size:11px;color:var(--text2);">Apuestas totales</div>
                    <div style="font-family:var(--h);font-size:22px;font-weight:700;color:var(--text);">
                        {{ $stats['totalBets'] }}
                    </div>
                </div>
                <div style="background:var(--bg3);border:1px solid var(--border2);border-radius:8px;padding:12px;">
                    <div style="font-size:11px;color:var(--text2);">Apuestas ganadas</div>
                    <div style="font-family:var(--h);font-size:22px;font-weight:700;color:var(--green);">
                        {{ $stats['wonBets'] }}
                    </div>
                </div>
                <div style="background:var(--bg3);border:1px solid var(--border2);border-radius:8px;padding:12px;">
                    <div style="font-size:11px;color:var(--text2);">Partidas minas</div>
                    <div style="font-family:var(--h);font-size:22px;font-weight:700;color:var(--violet);">
                        {{ $stats['mineGames'] }}
                    </div>
                </div>
                <div style="background:var(--bg3);border:1px solid var(--border2);border-radius:8px;padding:12px;">
                    <div style="font-size:11px;color:var(--text2);">Seguidores</div>
                    <div style="font-family:var(--h);font-size:22px;font-weight:700;color:var(--blue);">
                        {{ $stats['followers'] }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Transactions --}}
    <div>
        <div class="card">
            <div class="card-hdr">Últimas Transacciones</div>
            @if($transactions->isEmpty())
                <div class="empty">Sin movimientos</div>
            @else
            <div class="tw">
                <table>
                    <thead><tr>
                        <th>Tipo</th><th>Monto</th><th>Descripción</th><th>Fecha</th>
                    </tr></thead>
                    <tbody>
                    @foreach($transactions as $tx)
                    <tr>
                        <td><span class="bx {{ $tx->type }}">{{ str_replace('_',' ',$tx->type) }}</span></td>
                        <td class="{{ in_array($tx->type,['deposit','bet_win']) ? 'cg' : 'cr' }}">
                            {{ in_array($tx->type,['deposit','bet_win']) ? '+' : '-' }}${{ number_format($tx->amount,2) }}
                        </td>
                        <td style="font-size:12px;color:var(--text2);">{{ Str::limit($tx->description,28) ?? '—' }}</td>
                        <td class="cm">{{ $tx->created_at?->format('d/m H:i') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top:14px;display:flex;justify-content:flex-end;">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

@endsection