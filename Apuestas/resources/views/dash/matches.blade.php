@extends('dash.app')
@section('title',     'Partidos — Admin')
@section('page-slug', 'partidos')
@section('page-title','Partidos')
@section('page-desc', 'gestión de encuentros')

@section('content')

{{-- Filters --}}
<div class="card" style="padding:12px 16px;margin-bottom:16px;">
    <form method="GET" action="{{ route('dash.matches') }}"
          style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <select name="sport">
            <option value="">Todos los deportes</option>
            @foreach($sports as $s)
            <option value="{{ $s->id }}" {{ request('sport')==$s->id?'selected':'' }}>{{ $s->name }}</option>
            @endforeach
        </select>
        <select name="status">
            <option value="">Todos los estados</option>
            <option value="scheduled" {{ request('status')==='scheduled'?'selected':'' }}>scheduled</option>
            <option value="finished"  {{ request('status')==='finished' ?'selected':'' }}>finished</option>
        </select>
        <button type="submit" class="btn">filtrar</button>
        @if(request()->hasAny(['sport','status']))
        <a href="{{ route('dash.matches') }}" class="btn-ghost">limpiar</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-title">// lista de partidos</div>
    @if($matches->isEmpty())
        <div class="empty">sin_datos</div>
    @else
    <div class="tw">
        <table>
            <thead><tr>
                <th>#</th><th>Deporte</th><th>Local</th><th>Visitante</th>
                <th>Resultado</th><th>Fecha</th><th>Cuotas</th><th>Estado</th>
            </tr></thead>
            <tbody>
            @foreach($matches as $m)
            <tr>
                <td class="cm">{{ $m->id }}</td>
                <td class="cm">{{ $m->sport->name ?? '-' }}</td>
                <td style="font-weight:500;">{{ $m->teamHome->name }}</td>
                <td style="font-weight:500;">{{ $m->teamAway->name }}</td>
                <td class="cy">
                    @if($m->status === 'finished')
                        {{ $m->home_score }} — {{ $m->away_score }}
                    @else
                        <span class="cm">—</span>
                    @endif
                </td>
                <td class="cm">{{ $m->match_date?->format('d/m/Y H:i') }}</td>
                <td class="cm">{{ $m->odds->count() }}</td>
                <td><span class="b {{ $m->status }}">{{ $m->status }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        {{ $matches->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection