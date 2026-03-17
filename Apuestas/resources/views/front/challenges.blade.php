@extends('front.app')
@section('title', 'Desafíos — BetArena')

@section('content')

<div style="display:flex;align-items:baseline;gap:14px;margin-bottom:24px;flex-wrap:wrap;justify-content:space-between;">
    <div>
        <div style="font-family:var(--h);font-size:24px;font-weight:700;letter-spacing:1px;">
            ⚔️ Desafíos
        </div>
        <div style="font-size:13px;color:var(--text2);margin-top:4px;">Reta a otros jugadores</div>
    </div>
</div>

{{-- stats --}}
<div class="g4" style="margin-bottom:22px;">
    <div class="stat y"><div class="stat-label">Total</div><div class="stat-val">{{ $stats['total'] }}</div></div>
    <div class="stat b"><div class="stat-label">Pendientes</div><div class="stat-val">{{ $stats['pending'] }}</div></div>
    <div class="stat g"><div class="stat-label">Aceptados</div><div class="stat-val">{{ $stats['accepted'] }}</div></div>
    <div class="stat r"><div class="stat-label">Rechazados</div><div class="stat-val">{{ $stats['rejected'] }}</div></div>
</div>

<div class="card">
    <div class="card-hdr">Mis Desafíos</div>

    @if($challenges->isEmpty())
        <div class="empty">Sin desafíos registrados aún</div>
    @else
    <div class="tw">
        <table>
            <thead><tr>
                <th>#</th><th>Creador</th><th>Rival</th><th>Estado</th><th>Apuestas</th><th>Fecha</th>
            </tr></thead>
            <tbody>
            @foreach($challenges as $ch)
            <tr>
                <td class="cm">{{ $ch->id }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:28px;height:28px;background:linear-gradient(135deg,var(--gold2),var(--gold));
                            border-radius:50%;display:flex;align-items:center;justify-content:center;
                            font-family:var(--h);font-size:12px;font-weight:700;color:#000;flex-shrink:0;">
                            {{ strtoupper(substr($ch->creator->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:500;">{{ $ch->creator->name ?? '-' }}</div>
                            <div class="cm">@{{ $ch->creator->username ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:28px;height:28px;background:linear-gradient(135deg,#3498db,#60a5fa);
                            border-radius:50%;display:flex;align-items:center;justify-content:center;
                            font-family:var(--h);font-size:12px;font-weight:700;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr($ch->opponent->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:500;">{{ $ch->opponent->name ?? '-' }}</div>
                            <div class="cm">@{{ $ch->opponent->username ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="bx {{ $ch->status }}">{{ $ch->status }}</span></td>
                <td class="cm">{{ $ch->challengeBets->count() }} apuesta(s)</td>
                <td class="cm">{{ $ch->created_at?->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        {{ $challenges->links() }}
    </div>
    @endif
</div>

@endsection