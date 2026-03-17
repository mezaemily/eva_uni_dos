@extends('front.app')
@section('title', 'Minas — BetArena')

@section('content')

<div style="display:flex;align-items:baseline;gap:14px;margin-bottom:24px;">
    <div style="font-family:var(--h);font-size:24px;font-weight:700;letter-spacing:1px;">
        💣 Juego de Minas
    </div>
    <div style="font-size:13px;color:var(--text2);">Revela casillas, evita las minas</div>
</div>

<div class="g2">

    {{-- ACTIVE GAME --}}
    <div>
        @if($activeGame)
        <div class="card" style="border-color:rgba(139,92,246,.3);">
            <div class="card-hdr" style="color:var(--violet);">Partida en curso #{{ $activeGame->id }}</div>

            {{-- grid 5x5 --}}
            <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:6px;margin-bottom:18px;">
                @for($i = 0; $i < 25; $i++)
                    @php $tile = $activeGame->tiles->firstWhere('position', $i); @endphp
                    <div style="aspect-ratio:1;border-radius:8px;
                        border:1px solid {{ $tile && $tile->revealed ? ($tile->is_mine ? 'rgba(231,76,60,.5)' : 'rgba(46,204,113,.4)') : 'var(--border2)' }};
                        background:{{ $tile && $tile->revealed ? ($tile->is_mine ? 'rgba(231,76,60,.12)' : 'rgba(46,204,113,.08)') : 'var(--bg3)' }};
                        display:flex;align-items:center;justify-content:center;
                        font-size:20px;cursor:default;transition:all .2s;">
                        @if($tile && $tile->revealed)
                            {{ $tile->is_mine ? '💥' : '💎' }}
                        @else
                            <div style="width:10px;height:10px;border-radius:50%;background:var(--border2);"></div>
                        @endif
                    </div>
                @endfor
            </div>

            {{-- info --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                <div style="background:var(--bg3);border:1px solid var(--border2);border-radius:8px;
                    padding:10px;text-align:center;">
                    <div style="font-size:11px;color:var(--text2);margin-bottom:4px;">Apuesta</div>
                    <div style="font-family:var(--h);font-size:18px;font-weight:700;color:var(--gold);">
                        ${{ number_format($activeGame->bet_amount,2) }}
                    </div>
                </div>
                <div style="background:var(--bg3);border:1px solid var(--border2);border-radius:8px;
                    padding:10px;text-align:center;">
                    <div style="font-size:11px;color:var(--text2);margin-bottom:4px;">Multiplicador</div>
                    <div style="font-family:var(--h);font-size:18px;font-weight:700;color:var(--green);">
                        x{{ number_format($activeGame->multiplier,2) }}
                    </div>
                </div>
                <div style="background:var(--bg3);border:1px solid var(--border2);border-radius:8px;
                    padding:10px;text-align:center;">
                    <div style="font-size:11px;color:var(--text2);margin-bottom:4px;">Minas</div>
                    <div style="font-family:var(--h);font-size:18px;font-weight:700;color:var(--red);">
                        {{ $activeGame->mines }}
                    </div>
                </div>
            </div>
        </div>

        @else
        {{-- NO ACTIVE GAME --}}
        <div class="card" style="text-align:center;padding:36px 24px;">
            <div style="font-size:52px;margin-bottom:16px;">💣</div>
            <div style="font-family:var(--h);font-size:20px;font-weight:700;margin-bottom:8px;">
                Sin partida activa
            </div>
            <div style="font-size:13px;color:var(--text2);margin-bottom:20px;">
                Configura una nueva partida en el panel de la derecha
            </div>
            <div style="background:var(--bg3);border:1px solid var(--border2);border-radius:12px;
                padding:16px;text-align:left;font-size:12px;color:var(--text2);line-height:1.7;">
                <strong style="color:var(--text);display:block;margin-bottom:6px;">¿Cómo funciona?</strong>
                1. Elige cuántas minas quieres en el tablero (5×5)<br>
                2. A mayor número de minas → mayor multiplicador<br>
                3. Cada casilla segura que reveles aumenta tu ganancia<br>
                4. Si tocas una mina, pierdes tu apuesta 💥<br>
                5. Retira antes de explotar para cobrar 💎
            </div>
        </div>
        @endif
    </div>

    {{-- RIGHT: stats + history --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

        {{-- Quick stats --}}
        <div class="g2" style="gap:10px;">
            <div class="stat y">
                <div class="stat-label">Total jugadas</div>
                <div class="stat-val">{{ $stats['total'] }}</div>
            </div>
            <div class="stat g">
                <div class="stat-label">Ganadas</div>
                <div class="stat-val">{{ $stats['won'] }}</div>
                <div class="stat-sub cg">+${{ number_format($stats['total_winnings'],2) }}</div>
            </div>
            <div class="stat r">
                <div class="stat-label">Perdidas</div>
                <div class="stat-val">{{ $stats['lost'] }}</div>
            </div>
            <div class="stat b">
                <div class="stat-label">Win rate</div>
                <div class="stat-val">
                    {{ $stats['total'] > 0 ? round(($stats['won'] / $stats['total']) * 100) : 0 }}%
                </div>
            </div>
        </div>

        {{-- Recent games --}}
        <div class="card" style="flex:1;">
            <div class="card-hdr">Historial reciente</div>
            @if($recentGames->isEmpty())
                <div class="empty">Sin partidas registradas</div>
            @else
            <div class="tw">
                <table>
                    <thead><tr>
                        <th>Apuesta</th><th>Minas</th><th>×</th><th>Ganancia</th><th>Estado</th>
                    </tr></thead>
                    <tbody>
                    @foreach($recentGames as $g)
                    <tr>
                        <td class="cr">-${{ number_format($g->bet_amount,2) }}</td>
                        <td class="cy">{{ $g->mines }}</td>
                        <td class="cm">x{{ number_format($g->multiplier,2) }}</td>
                        <td>
                            @if($g->status === 'won')
                                <span class="cg">+${{ number_format($g->winnings,2) }}</span>
                            @elseif($g->status === 'lost')
                                <span class="cr">$0</span>
                            @else
                                <span class="cm">—</span>
                            @endif
                        </td>
                        <td><span class="bx {{ $g->status }}">{{ $g->status }}</span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    </div>
</div>

@endsection