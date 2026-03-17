@extends('front.app')
@section('title', 'BetArena — Inicio')

@section('content')

{{-- Hero greeting --}}
<div style="margin-bottom:28px;padding:28px 32px;
    background:linear-gradient(135deg, rgba(240,192,64,.06), rgba(139,92,246,.04));
    border:1px solid rgba(240,192,64,.12);
    border-radius:20px;
    display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">

    <div>
        <div style="font-family:var(--h);font-size:30px;font-weight:700;letter-spacing:1px;line-height:1.1;">
            Bienvenido, <span style="color:var(--gold)">{{ auth()->user()->name }}</span> 👋
        </div>
        <div style="color:var(--text2);font-size:14px;margin-top:6px;">
            Tus estadísticas de hoy
        </div>
    </div>

    <div style="display:flex;gap:20px;flex-wrap:wrap;">
        <div style="text-align:center;">
            <div style="font-family:var(--h);font-size:26px;font-weight:700;color:var(--green);">
                {{ $wonBets }}
            </div>
            <div style="font-size:11px;color:var(--text2);">Apuestas ganadas</div>
        </div>
        <div style="text-align:center;">
            <div style="font-family:var(--h);font-size:26px;font-weight:700;color:var(--gold);">
                {{ $pendingBets }}
            </div>
            <div style="font-size:11px;color:var(--text2);">En juego</div>
        </div>
        <div style="text-align:center;">
            <div style="font-family:var(--h);font-size:26px;font-weight:700;color:var(--blue);">
                ${{ number_format(auth()->user()->balance, 2) }}
            </div>
            <div style="font-size:11px;color:var(--text2);">Saldo disponible</div>
        </div>
    </div>
</div>

{{-- Quick access --}}
<div class="g3" style="margin-bottom:22px;">

    <a href="{{ route('front.matches') }}" style="text-decoration:none;">
        <div style="background:var(--card);border:1px solid var(--border);border-radius:var(--r2);
            padding:20px;transition:border-color .2s;cursor:pointer;display:flex;align-items:center;gap:14px;"
            onmouseover="this.style.borderColor='rgba(240,192,64,.35)'"
            onmouseout="this.style.borderColor='var(--border)'">
            <div style="font-size:36px;">⚽</div>
            <div>
                <div style="font-family:var(--h);font-size:17px;font-weight:700;letter-spacing:1px;">Apostar</div>
                <div style="font-size:12px;color:var(--text2);margin-top:2px;">{{ $scheduledMatches }} partidos disponibles</div>
            </div>
            <div style="margin-left:auto;color:var(--gold);font-size:20px;">→</div>
        </div>
    </a>

    <a href="{{ route('front.mines') }}" style="text-decoration:none;">
        <div style="background:var(--card);border:1px solid var(--border);border-radius:var(--r2);
            padding:20px;transition:border-color .2s;cursor:pointer;display:flex;align-items:center;gap:14px;"
            onmouseover="this.style.borderColor='rgba(139,92,246,.35)'"
            onmouseout="this.style.borderColor='var(--border)'">
            <div style="font-size:36px;">💣</div>
            <div>
                <div style="font-family:var(--h);font-size:17px;font-weight:700;letter-spacing:1px;">Minas</div>
                <div style="font-size:12px;color:var(--text2);margin-top:2px;">Juego de riesgo y recompensa</div>
            </div>
            <div style="margin-left:auto;color:var(--violet);font-size:20px;">→</div>
        </div>
    </a>

    <a href="{{ route('front.challenges') }}" style="text-decoration:none;">
        <div style="background:var(--card);border:1px solid var(--border);border-radius:var(--r2);
            padding:20px;transition:border-color .2s;cursor:pointer;display:flex;align-items:center;gap:14px;"
            onmouseover="this.style.borderColor='rgba(52,152,219,.35)'"
            onmouseout="this.style.borderColor='var(--border)'">
            <div style="font-size:36px;">⚔️</div>
            <div>
                <div style="font-family:var(--h);font-size:17px;font-weight:700;letter-spacing:1px;">Desafíos</div>
                <div style="font-size:12px;color:var(--text2);margin-top:2px;">{{ $pendingChallenges }} desafío(s) pendiente(s)</div>
            </div>
            <div style="margin-left:auto;color:var(--blue);font-size:20px;">→</div>
        </div>
    </a>

</div>

<div class="g2">

    {{-- Próximos partidos --}}
    <div class="card">
        <div class="card-hdr">Próximos Partidos</div>
        @if($nextMatches->isEmpty())
            <div class="empty">No hay partidos próximos</div>
        @else
        @foreach($nextMatches as $m)
        <div style="display:flex;align-items:center;justify-content:space-between;
            padding:12px 0;border-bottom:1px solid var(--border);gap:10px;"
            @if(!$loop->last) @endif>
            <div>
                <div style="font-family:var(--h);font-size:15px;font-weight:700;">
                    {{ $m->teamHome->name }}
                    <span class="vs">VS</span>
                    {{ $m->teamAway->name }}
                </div>
                <div style="font-size:11px;color:var(--text2);margin-top:3px;">
                    {{ $m->sport->name }} · {{ $m->match_date?->format('d/m H:i') }}
                </div>
            </div>
            <a href="{{ route('front.matches') }}" class="btn" style="padding:6px 14px;font-size:11px;">
                Apostar
            </a>
        </div>
        @endforeach
        <div style="border-bottom:none !important;"></div>
        @endif
    </div>

    {{-- Mis últimas apuestas --}}
    <div class="card">
        <div class="card-hdr">Mis Últimas Apuestas</div>
        @if($myBets->isEmpty())
            <div class="empty">Aún no has realizado apuestas</div>
        @else
        <div class="tw">
            <table>
                <thead><tr>
                    <th>Partido</th><th>Monto</th><th>Estado</th>
                </tr></thead>
                <tbody>
                @foreach($myBets as $bet)
                <tr>
                    <td>
                        <div style="font-size:13px;font-weight:500;">
                            {{ $bet->match->teamHome->name ?? '?' }}
                            <span class="vs">vs</span>
                            {{ $bet->match->teamAway->name ?? '?' }}
                        </div>
                        <div class="cm">{{ $bet->odd->option_name ?? '-' }}</div>
                    </td>
                    <td class="cr">-${{ number_format($bet->amount,2) }}</td>
                    <td><span class="bx {{ $bet->status }}">{{ $bet->status }}</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection