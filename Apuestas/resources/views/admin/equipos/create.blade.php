@extends('dash.app')
@section('title', 'Nuevo Equipo')
@section('page-slug', 'equipos')
@section('page-title', 'Nuevo Equipo')
@section('page-desc', 'Registrar equipo')

@section('content')
@include('admin.partials.alerts')
<div style="max-width:520px;"><div class="card">
    <form action="{{ route('admin.equipos.store') }}" method="POST">
        @csrf
        <div style="margin-bottom:16px;">
            <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Deporte *</label>
            <select name="sport_id" style="width:100%;{{ $errors->has('sport_id') ? 'border-color:#f87171;' : '' }}">
                <option value="">-- Seleccionar deporte --</option>
                @foreach($deportes as $d)
                    <option value="{{ $d->id }}" {{ old('sport_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                @endforeach
            </select>
            @error('sport_id')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div style="margin-bottom:16px;">
            <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Nombre *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Real Madrid..."
                   style="width:100%;{{ $errors->has('name') ? 'border-color:#f87171;' : '' }}">
            @error('name')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div style="margin-bottom:24px;">
            <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Fortaleza * (1-100)</label>
            <input type="number" name="strength" value="{{ old('strength', 50) }}" min="1" max="100"
                   style="width:100%;{{ $errors->has('strength') ? 'border-color:#f87171;' : '' }}">
            @error('strength')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('admin.equipos.index') }}" class="btn-ghost">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection