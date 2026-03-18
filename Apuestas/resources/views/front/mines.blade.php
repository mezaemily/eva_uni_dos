@extends('front.app')
@section('title', 'Minas — BetArena')

@section('content')

<div style="display:grid;grid-template-columns:380px 1fr;gap:24px;align-items:start;">

    {{-- ══ PANEL IZQUIERDO ══ --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        <div class="card" id="configPanel">
            <div class="card-hdr">💣 Mines</div>

            {{-- Formulario de configuración --}}
            <div id="setupForm">
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:11px;color:var(--text2);margin-bottom:6px;
                                  text-transform:uppercase;letter-spacing:1px;">Monto a apostar</label>
                    <div style="position:relative;margin-bottom:8px;">
                        <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);
                                     color:var(--gold);font-weight:700;">$</span>
                        <input type="number" id="betAmount" value="100" min="1" step="1"
                               style="width:100%;padding-left:24px;">
                    </div>
                    <div style="display:flex;gap:6px;">
                        @foreach([50, 100, 250, 500] as $amt)
                        <button onclick="setBet({{ $amt }})"
                                style="flex:1;background:var(--bg3);border:1px solid var(--border2);
                                       color:var(--text2);padding:5px 0;border-radius:6px;
                                       font-size:11px;cursor:pointer;transition:all .15s;"
                                onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'"
                                onmouseout="this.style.borderColor='var(--border2)';this.style.color='var(--text2)'">
                            ${{ $amt }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:11px;color:var(--text2);margin-bottom:6px;
                                  text-transform:uppercase;letter-spacing:1px;">Número de minas</label>
                    <select id="minesCount" style="width:100%;">
                        @for($i = 1; $i <= 24; $i++)
                            <option value="{{ $i }}" {{ $i === 3 ? 'selected' : '' }}>
                                {{ $i }} {{ $i === 1 ? 'mina' : 'minas' }}
                            </option>
                        @endfor
                    </select>
                    <div style="margin-top:8px;font-size:11px;color:var(--muted2);">
                        Multiplicador inicial:
                        <span id="initMult" style="color:var(--gold);font-weight:600;">x1.12</span>
                    </div>
                </div>

                <button id="btnStart" onclick="iniciarJuego()"
                        style="width:100%;background:linear-gradient(135deg,var(--gold2),var(--gold));
                               color:#000;border:none;padding:13px;border-radius:8px;
                               font-family:var(--h);font-size:16px;font-weight:700;
                               letter-spacing:1px;cursor:pointer;transition:opacity .15s;">
                    JUGAR
                </button>
            </div>

            {{-- Panel activo durante la partida --}}
            <div id="activePanel" style="display:none;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px;">
                    <div style="background:var(--bg3);border:1px solid var(--border2);
                                border-radius:8px;padding:12px;text-align:center;">
                        <div style="font-size:11px;color:var(--text2);margin-bottom:4px;">Apuesta</div>
                        <div style="font-family:var(--h);font-size:20px;font-weight:700;color:var(--red);">
                            $<span id="displayBet">0</span>
                        </div>
                    </div>
                    <div style="background:var(--bg3);border:1px solid var(--border2);
                                border-radius:8px;padding:12px;text-align:center;">
                        <div style="font-size:11px;color:var(--text2);margin-bottom:4px;">Minas</div>
                        <div style="font-family:var(--h);font-size:20px;font-weight:700;color:var(--red);">
                            💣 <span id="displayMines">0</span>
                        </div>
                    </div>
                </div>

                <div style="background:linear-gradient(135deg,rgba(240,192,64,.08),rgba(240,192,64,.03));
                            border:1px solid rgba(240,192,64,.2);border-radius:10px;
                            padding:16px;text-align:center;margin-bottom:16px;">
                    <div style="font-size:11px;color:var(--text2);margin-bottom:4px;
                                text-transform:uppercase;letter-spacing:1px;">Multiplicador</div>
                    <div id="multiplierDisplay"
                         style="font-family:var(--h);font-size:36px;font-weight:700;
                                color:var(--gold);letter-spacing:1px;">
                        x1.00
                    </div>
                    <div style="font-size:12px;color:var(--text2);margin-top:4px;">
                        Ganancia potencial:
                        <span id="potentialWin" style="color:var(--green);font-weight:600;">$0</span>
                    </div>
                </div>

                <button id="btnCashout" onclick="cobrar()" disabled
                        style="width:100%;background:linear-gradient(135deg,#16a34a,#22c55e);
                               color:#fff;border:none;padding:13px;border-radius:8px;
                               font-family:var(--h);font-size:15px;font-weight:700;
                               letter-spacing:1px;cursor:pointer;opacity:0.5;transition:opacity .15s;">
                    💰 COBRAR
                </button>
                <div style="text-align:center;margin-top:8px;font-size:11px;color:var(--muted2);">
                    Revela al menos una celda para cobrar
                </div>
            </div>
        </div>

        {{-- Saldo --}}
        <div class="card" style="text-align:center;">
            <div style="font-size:11px;color:var(--text2);text-transform:uppercase;
                        letter-spacing:1px;margin-bottom:6px;">Tu saldo</div>
            <div id="balanceDisplay"
                 style="font-family:var(--h);font-size:28px;font-weight:700;color:var(--gold);">
                ${{ number_format(auth()->user()->balance ?? 0, 2) }}
            </div>
        </div>

        {{-- Estadísticas --}}
        <div class="card">
            <div class="card-hdr">Mis estadísticas</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                <div style="background:var(--bg3);border-radius:8px;padding:12px;text-align:center;">
                    <div style="font-size:11px;color:var(--text2);margin-bottom:4px;">Partidas</div>
                    <div style="font-family:var(--h);font-size:22px;font-weight:700;">
                        {{ $stats['total'] }}
                    </div>
                </div>
                <div style="background:var(--bg3);border-radius:8px;padding:12px;text-align:center;">
                    <div style="font-size:11px;color:var(--green);margin-bottom:4px;">Ganadas</div>
                    <div style="font-family:var(--h);font-size:22px;font-weight:700;color:var(--green);">
                        {{ $stats['won'] }}
                    </div>
                </div>
                <div style="background:var(--bg3);border-radius:8px;padding:12px;text-align:center;">
                    <div style="font-size:11px;color:var(--red);margin-bottom:4px;">Perdidas</div>
                    <div style="font-family:var(--h);font-size:22px;font-weight:700;color:var(--red);">
                        {{ $stats['lost'] }}
                    </div>
                </div>
                <div style="background:var(--bg3);border-radius:8px;padding:12px;text-align:center;">
                    <div style="font-size:11px;color:var(--gold);margin-bottom:4px;">Ganancias</div>
                    <div style="font-family:var(--h);font-size:18px;font-weight:700;color:var(--gold);">
                        ${{ number_format($stats['total_winnings'], 0) }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══ PANEL DERECHO ══ --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Tablero --}}
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <div class="card-hdr" style="margin:0;">Tablero 5×5</div>
                <div id="gameStatus" style="font-size:12px;color:var(--muted2);">
                    Configura tu apuesta para empezar
                </div>
            </div>

            <div id="board" style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;">
                @for($i = 0; $i < 25; $i++)
                <button class="tile" data-pos="{{ $i }}"
                        onclick="revelarCelda({{ $i }})"
                        disabled
                        style="aspect-ratio:1;border-radius:10px;border:2px solid var(--border2);
                               background:var(--bg3);cursor:not-allowed;font-size:20px;
                               transition:all .2s;display:flex;align-items:center;
                               justify-content:center;">
                    💎
                </button>
                @endfor
            </div>
        </div>

        {{-- Historial --}}
        <div class="card">
            <div class="card-hdr">Últimas partidas</div>
            @if($recentGames->isEmpty())
                <div class="empty">Aún no has jugado ninguna partida</div>
            @else
            <div class="tw">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Apuesta</th>
                            <th>Minas</th>
                            <th>Multiplicador</th>
                            <th>Resultado</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentGames as $g)
                        <tr>
                            <td class="cm">{{ $g->id }}</td>
                            <td class="cr">-${{ number_format($g->bet_amount, 2) }}</td>
                            <td class="cm">{{ $g->mines }} 💣</td>
                            <td class="cy">x{{ number_format($g->multiplier, 2) }}</td>
                            <td>
                                @if($g->status === 'won')
                                    <span style="color:var(--green);font-weight:600;">
                                        +${{ number_format($g->winnings, 2) }}
                                    </span>
                                @elseif($g->status === 'lost')
                                    <span style="color:var(--red);">
                                        -${{ number_format($g->bet_amount, 2) }}
                                    </span>
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

@push('scripts')
<script>
const CSRF   = '{{ csrf_token() }}';
let gameId   = null;
let betAmt   = 0;
let revealed = 0;

document.addEventListener('DOMContentLoaded', () => {
    actualizarMultInicial();
    document.getElementById('minesCount').addEventListener('change', actualizarMultInicial);
    cargarPartidaActiva();
});

function setBet(amount) {
    document.getElementById('betAmount').value = amount;
}

function actualizarMultInicial() {
    const mines = parseInt(document.getElementById('minesCount').value);
    const mult  = calcMult(0, mines);
    document.getElementById('initMult').textContent = 'x' + mult.toFixed(2);
}

function calcMult(revealed, mines) {
    const total = 25;
    const safe  = total - mines;
    let prob    = 1.0;
    for (let i = 0; i < revealed; i++) {
        prob *= (safe - i) / (total - i);
    }
    if (prob <= 0) return 1.0;
    return Math.max((1 / prob) * 0.97, 1.01);
}

async function cargarPartidaActiva() {
    const res  = await fetch('{{ route("mines.status") }}');
    const data = await res.json();
    if (data.active) {
        gameId   = data.game_id;
        betAmt   = data.bet_amount;
        revealed = data.revealed_count;
        mostrarPanelActivo(data.bet_amount, data.mines);
        actualizarMultiplicador(data.multiplier, data.potential);
        data.revealed.forEach(pos => marcarSegura(pos));
        if (revealed > 0) habilitarCashout();
        setEstado('🎮 Partida en curso — ¡sigue revelando!', 'var(--gold)');
    }
}

async function iniciarJuego() {
    const bet   = parseFloat(document.getElementById('betAmount').value);
    const mines = parseInt(document.getElementById('minesCount').value);
    if (!bet || bet < 1) { alert('Ingresa un monto válido.'); return; }

    const btn       = document.getElementById('btnStart');
    btn.textContent = 'Iniciando...';
    btn.disabled    = true;

    const res  = await fetch('{{ route("mines.start") }}', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body:    JSON.stringify({ bet_amount: bet, mines: mines }),
    });
    const data = await res.json();

    if (data.error) {
        alert(data.error);
        btn.textContent = 'JUGAR';
        btn.disabled    = false;
        return;
    }

    gameId   = data.game_id;
    betAmt   = data.bet_amount;
    revealed = 0;

    resetTablero();
    mostrarPanelActivo(data.bet_amount, mines);
    actualizarMultiplicador(data.multiplier, 0);
    actualizarBalance(data.balance);
    setEstado('💎 Elige una celda', 'var(--text2)');
}

async function revelarCelda(pos) {
    if (!gameId) return;

    const tile       = document.querySelector(`.tile[data-pos="${pos}"]`);
    tile.disabled    = true;
    tile.textContent = '⏳';

    const res  = await fetch('{{ route("mines.reveal") }}', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body:    JSON.stringify({ game_id: gameId, position: pos }),
    });
    const data = await res.json();

    if (data.result === 'mine') {
        tile.style.background  = 'rgba(248,113,113,.25)';
        tile.style.borderColor = '#f87171';
        tile.textContent       = '💣';
        data.mines.forEach(minePos => { if (minePos !== pos) marcarMina(minePos); });
        gameOver(false, 0, data.balance);

    } else if (data.result === 'safe') {
        marcarSegura(pos);
        revealed = data.revealed;
        actualizarMultiplicador(data.multiplier, data.potential);
        habilitarCashout();
        setEstado(`✅ ${data.revealed}/${data.safe_cells} seguras — x${data.multiplier.toFixed(2)}`, 'var(--green)');

    } else if (data.result === 'cashout') {
        marcarSegura(pos);
        data.mines.forEach(minePos => marcarMina(minePos));
        gameOver(true, data.winnings, data.balance);
    }
}

async function cobrar() {
    if (!gameId) return;
    const btn       = document.getElementById('btnCashout');
    btn.disabled    = true;
    btn.textContent = '⏳ Procesando...';

    const res  = await fetch('{{ route("mines.cashout") }}', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body:    JSON.stringify({ game_id: gameId }),
    });
    const data = await res.json();

    if (data.error) {
        alert(data.error);
        btn.disabled    = false;
        btn.textContent = '💰 COBRAR';
        return;
    }

    data.mines.forEach(pos => marcarMina(pos));
    gameOver(true, data.winnings, data.balance);
}

function marcarSegura(pos) {
    const tile = document.querySelector(`.tile[data-pos="${pos}"]`);
    if (!tile) return;
    tile.disabled          = true;
    tile.textContent       = '💎';
    tile.style.background  = 'rgba(52,211,153,.2)';
    tile.style.borderColor = '#34d399';
    tile.style.transform   = 'scale(1.05)';
    tile.style.cursor      = 'default';
}

function marcarMina(pos) {
    const tile = document.querySelector(`.tile[data-pos="${pos}"]`);
    if (!tile) return;
    tile.disabled          = true;
    tile.textContent       = '💣';
    tile.style.background  = 'rgba(248,113,113,.2)';
    tile.style.borderColor = '#f87171';
    tile.style.cursor      = 'default';
}

function resetTablero() {
    document.querySelectorAll('.tile').forEach(tile => {
        tile.disabled          = false;
        tile.textContent       = '💎';
        tile.style.background  = 'var(--bg3)';
        tile.style.borderColor = 'var(--border2)';
        tile.style.transform   = '';
        tile.style.cursor      = 'pointer';
    });
}

function mostrarPanelActivo(bet, mines) {
    document.getElementById('setupForm').style.display   = 'none';
    document.getElementById('activePanel').style.display = 'block';
    document.getElementById('displayBet').textContent    = bet;
    document.getElementById('displayMines').textContent  = mines;
}

function mostrarPanelSetup() {
    document.getElementById('setupForm').style.display   = 'block';
    document.getElementById('activePanel').style.display = 'none';
    const btn       = document.getElementById('btnStart');
    btn.textContent = 'JUGAR';
    btn.disabled    = false;
}

function actualizarMultiplicador(mult, potential) {
    document.getElementById('multiplierDisplay').textContent = 'x' + parseFloat(mult).toFixed(2);
    document.getElementById('potentialWin').textContent      = '$' + parseFloat(potential).toFixed(2);
}

function habilitarCashout() {
    const btn         = document.getElementById('btnCashout');
    btn.disabled      = false;
    btn.style.opacity = '1';
    btn.textContent   = '💰 COBRAR';
}

function actualizarBalance(balance) {
    document.getElementById('balanceDisplay').textContent =
        '$' + parseFloat(balance).toLocaleString('es-MX', { minimumFractionDigits: 2 });
}

function setEstado(msg, color) {
    const el       = document.getElementById('gameStatus');
    el.textContent = msg;
    el.style.color = color;
}

function gameOver(won, winnings, balance) {
    gameId = null;
    document.querySelectorAll('.tile').forEach(t => {
        t.disabled     = true;
        t.style.cursor = 'default';
    });

    actualizarBalance(balance);

    if (won) {
        setEstado(`🏆 ¡Ganaste $${parseFloat(winnings).toFixed(2)}!`, 'var(--green)');
        document.getElementById('multiplierDisplay').style.color = '#4ade80';
    } else {
        setEstado('💥 ¡Boom! Encontraste una mina.', 'var(--red)');
        document.getElementById('multiplierDisplay').textContent = 'x0.00';
        document.getElementById('multiplierDisplay').style.color = '#f87171';
        document.getElementById('potentialWin').textContent      = '$0.00';
    }

    setTimeout(() => {
        mostrarPanelSetup();
        location.reload();
    }, 3000);
}
</script>
@endpush