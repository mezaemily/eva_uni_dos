@extends('dash.app')
@section('title', 'Nuevo Usuario')
@section('page-slug', 'usuarios')
@section('page-title', 'Nuevo Usuario')
@section('page-desc', 'Registrar usuario')

@section('content')
@include('admin.partials.alerts')
<div style="max-width:640px;">
<div class="card">
    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Nombre *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Juan Pérez"
                       style="width:100%;{{ $errors->has('name') ? 'border-color:#f87171;' : '' }}">
                @error('name')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Username *</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="juanperez"
                       style="width:100%;{{ $errors->has('username') ? 'border-color:#f87171;' : '' }}">
                @error('username')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>
        <div style="margin-bottom:16px;">
            <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Correo *</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com"
                   style="width:100%;{{ $errors->has('email') ? 'border-color:#f87171;' : '' }}">
            @error('email')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Contraseña *</label>
                <input type="password" name="password" placeholder="Mínimo 8 caracteres"
                       style="width:100%;{{ $errors->has('password') ? 'border-color:#f87171;' : '' }}">
                @error('password')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Confirmar contraseña *</label>
                <input type="password" name="password_confirmation" placeholder="Repite la contraseña" style="width:100%;">
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Saldo inicial *</label>
                <input type="number" name="balance" value="{{ old('balance', 0) }}" min="0" step="0.01"
                       style="width:100%;{{ $errors->has('balance') ? 'border-color:#f87171;' : '' }}">
                @error('balance')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Rol *</label>
                <select name="role" style="width:100%;">
                    <option value="user"  {{ old('role') === 'user'  ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
</div>
@endsection