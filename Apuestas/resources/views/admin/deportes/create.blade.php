@extends('dash.app')
@section('title', 'Nuevo Deporte')
@section('page-slug', 'deportes')
@section('page-title', 'Nuevo Deporte')
@section('page-desc', 'Registrar deporte')

@section('content')
@include('admin.partials.alerts')
<div style="max-width:480px;"><div class="card">
    <form action="{{ route('admin.deportes.store') }}" method="POST">
        @csrf
        <div style="margin-bottom:20px;">
            <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Nombre *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Fútbol, Tenis..."
                   style="width:100%;{{ $errors->has('name') ? 'border-color:#f87171;' : '' }}">
            @error('name')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('admin.deportes.index') }}" class="btn-ghost">Cancelar</a>
        </div>
    </form>
</div></div>
@endsection