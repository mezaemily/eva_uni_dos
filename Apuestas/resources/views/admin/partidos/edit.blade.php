@extends('dash.app')
@section('title', 'Editar Partido')
@section('page-slug', 'partidos')
@section('page-title', 'Editar Partido')
@section('page-desc', '{{ $partido->teamHome->name ?? "" }} vs {{ $partido->teamAway->name ?? "" }}')

@section('content')
@include('admin.partials.alerts')
<div style="max-width:600px;"><div class="card">
    <form action="{{ route('admin.partidos.update', $partido) }}" method="POST">
        @csrf @method('PUT')

        <div style="margin-bottom:16px;">
            <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Deporte *</label>
            <select name="sport_id" id="sport_id" onchange="filtrarEquipos()"
                    style="width:100%;">
                @foreach($deportes as $d)
                    <option value="{{ $d->id }}" {{ old('sport_id', $partido->sport_id) == $d->id ? 'selected' : '' }}>
                        {{ $d->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Equipo Local *</label>
                <select name="team_home_id" id="team_home_id"
                        style="width:100%;{{ $errors->has('team_home_id') ? 'border-color:#f87171;' : '' }}">
                    @foreach($equipos as $e)
                        <option value="{{ $e->id }}" data-sport="{{ $e->sport_id }}"
                                {{ old('team_home_id', $partido->team_home_id) == $e->id ? 'selected' : '' }}>
                            {{ $e->name }}
                        </option>
                    @endforeach
                </select>
                @error('team_home_id')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Equipo Visitante *</label>
                <select name="team_away_id" id="team_away_id"
                        style="width:100%;{{ $errors->has('team_away_id') ? 'border-color:#f87171;' : '' }}">
                    @foreach($equipos as $e)
                        <option value="{{ $e->id }}" data-sport="{{ $e->sport_id }}"
                                {{ old('team_away_id', $partido->team_away_id) == $e->id ? 'selected' : '' }}>
                            {{ $e->name }}
                        </option>
                    @endforeach
                </select>
                @error('team_away_id')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Fecha y Hora *</label>
                <input type="datetime-local" name="match_date"
                       value="{{ old('match_date', $partido->match_date?->format('Y-m-d\TH:i')) }}"
                       style="width:100%;">
                @error('match_date')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Estado *</label>
                <select name="status" style="width:100%;">
                    @foreach(['scheduled'=>'Programado','live'=>'En Vivo','finished'=>'Terminado','cancelled'=>'Cancelado'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $partido->status) === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Marcador Local</label>
                <input type="number" name="home_score" min="0"
                       value="{{ old('home_score', $partido->home_score) }}"
                       placeholder="—" style="width:100%;">
                @error('home_score')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Marcador Visitante</label>
                <input type="number" name="away_score" min="0"
                       value="{{ old('away_score', $partido->away_score) }}"
                       placeholder="—" style="width:100%;">
                @error('away_score')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn">Actualizar Partido</button>
            <a href="{{ route('admin.partidos.index') }}" class="btn-ghost">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection

@push('scripts')
<script>
function filtrarEquipos() {
    const sportId    = document.getElementById('sport_id').value;
    const homeSelect = document.getElementById('team_home_id');
    const awaySelect = document.getElementById('team_away_id');

    [homeSelect, awaySelect].forEach(select => {
        const opciones = select.querySelectorAll('option');

        opciones.forEach(op => {
            if (!op.value) return;
            op.style.display = (!sportId || op.dataset.sport === sportId) ? '' : 'none';
        });

        // Si el equipo seleccionado no es del deporte elegido, limpiar
        const seleccionado = select.options[select.selectedIndex];
        if (seleccionado && seleccionado.value && seleccionado.dataset.sport !== sportId) {
            select.value = '';
        }
    });
}

// Al cargar ya filtra con el deporte actual del partido
document.addEventListener('DOMContentLoaded', () => {
    filtrarEquipos();
});
</script>
@endpush