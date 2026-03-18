@extends('dash.app')
@section('title', 'Editar Usuario')
@section('page-slug', 'usuarios')
@section('page-title', 'Editar Usuario')
@section('page-desc', '{{ $usuario->name }}')

@section('content')
@include('admin.partials.alerts')
<div style="max-width:640px;">
<div class="card">
    <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                       style="width:100%;{{ $errors->has('name') ? 'border-color:#f87171;' : '' }}">
                @error('name')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Username *</label>
                <input type="text" name="username" value="{{ old('username', $usuario->username) }}"
                       style="width:100%;{{ $errors->has('username') ? 'border-color:#f87171;' : '' }}">
                @error('username')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
        </div>
        <div style="margin-bottom:16px;">
            <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Correo *</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                   style="width:100%;{{ $errors->has('email') ? 'border-color:#f87171;' : '' }}">
            @error('email')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
        </div>
        <div style="margin-bottom:6px;font-family:var(--mono);font-size:10px;color:var(--muted2);text-transform:uppercase;letter-spacing:1px;">
            Nueva contraseña (dejar vacío para no cambiar)
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <input type="password" name="password" placeholder="Nueva contraseña"
                       style="width:100%;{{ $errors->has('password') ? 'border-color:#f87171;' : '' }}">
                @error('password')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" style="width:100%;">
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Saldo *</label>
                <input type="number" name="balance" value="{{ old('balance', $usuario->balance) }}" min="0" step="0.01"
                       style="width:100%;{{ $errors->has('balance') ? 'border-color:#f87171;' : '' }}">
                @error('balance')<div style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="display:block;font-family:var(--mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted2);margin-bottom:6px;">Rol *</label>
                <select name="role" style="width:100%;">
                    <option value="user"  {{ old('role', $usuario->role) === 'user'  ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ old('role', $usuario->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
</div>
@endsection