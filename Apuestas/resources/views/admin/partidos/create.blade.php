@extends('dash.app')
@section('title', 'Nuevo Partido')
@section('page-slug', 'partidos')
@section('page-title', 'Nuevo Partido')
@section('page-desc', 'Registrar partido')

@section('content')
@include('admin.partials.alerts')
<div style="max-width:600px;"><div class="card">
    <form action="{{ route('admin.partidos.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:16px;">
            <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Deporte *</label>
            <select name="sport_id" id="sport_id" onchange="filtrarEquipos()"
                    style="width:100%;{{ $errors->has('sport_id') ? 'border-color:#f87171;' : '' }}">
                <option value="">-- Seleccionar --</option>
                @foreach($deportes as $d)
                    <option value="{{ $d->id }}" {{ old('sport_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->name }}
                    </option>
                @endforeach
            </select>
            @error('sport_id')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Equipo Local *</label>
                <select name="team_home_id" id="team_home_id"
                        style="width:100%;{{ $errors->has('team_home_id') ? 'border-color:#f87171;' : '' }}">
                    <option value="">-- Seleccionar deporte primero --</option>
                    @foreach($equipos as $e)
                        <option value="{{ $e->id }}" data-sport="{{ $e->sport_id }}"
                                {{ old('team_home_id') == $e->id ? 'selected' : '' }}>
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
                    <option value="">-- Seleccionar deporte primero --</option>
                    @foreach($equipos as $e)
                        <option value="{{ $e->id }}" data-sport="{{ $e->sport_id }}"
                                {{ old('team_away_id') == $e->id ? 'selected' : '' }}>
                            {{ $e->name }}
                        </option>
                    @endforeach
                </select>
                @error('team_away_id')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Fecha y Hora *</label>
                <input type="datetime-local" name="match_date" value="{{ old('match_date') }}"
                       style="width:100%;{{ $errors->has('match_date') ? 'border-color:#f87171;' : '' }}">
                @error('match_date')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Estado *</label>
                <select name="status" style="width:100%;">
                    <option value="scheduled" {{ old('status') === 'scheduled' ? 'selected' : '' }}>Programado</option>
                    <option value="live"      {{ old('status') === 'live'      ? 'selected' : '' }}>En Vivo</option>
                    <option value="finished"  {{ old('status') === 'finished'  ? 'selected' : '' }}>Terminado</option>
                    <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn">Guardar Partido</button>
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
            if (!op.value) {
                op.textContent = sportId ? '-- Seleccionar equipo --' : '-- Seleccionar deporte primero --';
                return;
            }
            op.style.display = (!sportId || op.dataset.sport === sportId) ? '' : 'none';
        });

        // Si el equipo seleccionado no es del deporte elegido, limpiar
        const seleccionado = select.options[select.selectedIndex];
        if (seleccionado && seleccionado.value && seleccionado.dataset.sport !== sportId) {
            select.value = '';
        }
    });
}

// Al cargar la página, si ya hay deporte seleccionado (al volver con errores de validación)
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('sport_id').value) {
        filtrarEquipos();
    }
});
</script>
@endpush