@extends('front.app')
@section('title', 'Partidos — BetArena')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
    <div>
        <div style="font-family:var(--h);font-size:24px;font-weight:700;letter-spacing:1px;">
            Partidos disponibles
        </div>
        <div style="font-size:13px;color:var(--text2);margin-top:4px;">
            Elige un partido y selecciona tu apuesta
        </div>
    </div>

    <form method="GET" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
        <select name="sport">
            <option value="">Todos los deportes</option>
            @foreach($sports as $s)
            <option value="{{ $s->id }}" {{ request('sport')==$s->id?'selected':'' }}>{{ $s->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn">Filtrar</button>
        @if(request()->filled('sport'))
        <a href="{{ route('front.matches') }}" class="btn-ghost">Limpiar</a>
        @endif
    </form>
</div>

@if($matches->isEmpty())
    <div class="card"><div class="empty">No hay partidos disponibles ahora mismo.</div></div>
@else
<div class="g3">
    @foreach($matches as $match)
    <div class="card" style="display:flex;flex-direction:column;gap:14px;transition:border-color .2s;"
        onmouseover="this.style.borderColor='rgba(240,192,64,.25)'"
        onmouseout="this.style.borderColor='var(--border)'">

        {{-- sport + status --}}
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:11px;color:var(--text2);text-transform:uppercase;letter-spacing:1px;font-family:var(--h);">
                {{ $match->sport->name ?? '' }}
            </span>
            <span class="bx {{ $match->status }}">{{ $match->status }}</span>
        </div>

        {{-- teams --}}
        <div style="display:flex;align-items:center;justify-content:space-between;text-align:center;gap:8px;">
            <div style="flex:1;">
                <div style="font-family:var(--h);font-size:18px;font-weight:700;letter-spacing:.5px;line-height:1.1;">
                    {{ $match->teamHome->name }}
                </div>
                <div style="font-size:10px;color:var(--muted2);text-transform:uppercase;letter-spacing:1px;margin-top:4px;">Local</div>
            </div>

            <div style="padding:0 10px;">
                @if($match->status === 'finished')
                    <div style="font-family:var(--h);font-size:30px;font-weight:700;
                        color:var(--gold);letter-spacing:3px;text-shadow:0 0 20px rgba(240,192,64,.3);">
                        {{ $match->home_score }}—{{ $match->away_score }}
                    </div>
                    <div style="font-size:10px;color:var(--muted2);text-align:center;">FINAL</div>
                @else
                    <div class="vs" style="font-size:14px;padding:5px 10px;">VS</div>
                    <div style="font-size:11px;color:var(--text2);margin-top:6px;text-align:center;">
                        {{ $match->match_date?->format('d/m · H:i') }}
                    </div>
                @endif
            </div>

            <div style="flex:1;">
                <div style="font-family:var(--h);font-size:18px;font-weight:700;letter-spacing:.5px;line-height:1.1;">
                    {{ $match->teamAway->name }}
                </div>
                <div style="font-size:10px;color:var(--muted2);text-transform:uppercase;letter-spacing:1px;margin-top:4px;">Visitante</div>
            </div>
        </div>

        {{-- odds --}}
        @if($match->odds->count() > 0 && $match->status === 'scheduled')
        <div>
            <div style="font-size:11px;color:var(--muted2);text-transform:uppercase;
                letter-spacing:1px;margin-bottom:8px;font-family:var(--h);">Cuotas</div>
            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                @foreach($match->odds->take(3) as $odd)
                <div style="flex:1;min-width:60px;background:var(--bg3);
                    border:1px solid var(--border2);border-radius:8px;
                    padding:8px 6px;text-align:center;cursor:pointer;transition:all .15s;"
                    onmouseover="this.style.borderColor='var(--gold)';this.style.background='rgba(240,192,64,.07)'"
                    onmouseout="this.style.borderColor='var(--border2)';this.style.background='var(--bg3)'">
                    <div style="font-size:10px;color:var(--text2);margin-bottom:4px;line-height:1.2;">
                        {{ Str::limit($odd->option_name, 12) }}
                    </div>
                    <div style="font-family:var(--h);font-size:20px;font-weight:700;color:var(--gold);">
                        x{{ number_format($odd->odd_value,2) }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- comment count --}}
        <div style="font-size:11px;color:var(--muted2);padding-top:6px;border-top:1px solid var(--border);">
            💬 {{ $match->comments->count() }} comentario(s)
        </div>

    </div>
    @endforeach
</div>

<div style="margin-top:22px;display:flex;justify-content:flex-end;">
    {{ $matches->withQueryString()->links() }}
</div>
@endif

@endsection