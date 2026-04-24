@extends('dash.app')
@section('title', 'Usuarios — Admin')
@section('page-slug', 'usuarios')
@section('page-title', 'Usuarios')
@section('page-desc', 'Gestión de usuarios')

@section('content')
@include('admin.partials.alerts')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div style="font-family:var(--mono);font-size:13px;color:var(--muted2);">{{ $usuarios->total() }} usuarios</div>
    <a href="{{ route('admin.usuarios.create') }}"
       style="background:var(--accent);color:#000;padding:8px 18px;border-radius:6px;
              font-family:var(--mono);font-size:12px;font-weight:600;text-decoration:none;">
        + Nuevo Usuario
    </a>
</div>

<div class="card">
    <div class="tw">
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Nombre</th><th>Username</th><th>Email</th>
                    <th>Saldo</th><th>Apuestas</th><th>Rol</th><th>Registro</th>
                    <th style="text-align:center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $u)
                <tr>
                    <td class="cm">{{ $u->id }}</td>
                    <td style="font-weight:500">{{ $u->name }}</td>
                    <td class="cm">{{ $u->username }}</td>
                    <td style="font-size:12px;color:var(--text2)">{{ $u->email }}</td>
                    <td class="{{ $u->balance > 0 ? 'cg' : 'cm' }}">${{ number_format($u->balance ?? 0, 2) }}</td>
                    <td class="cm">{{ $u->bets_count }}</td>
                    <td><span class="b {{ $u->role }}">{{ $u->role }}</span></td>
                    <td class="cm">{{ $u->created_at?->format('d/m/Y') }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admin.usuarios.edit', $u) }}"
                           style="background:rgba(240,192,64,.15);color:var(--accent);border:1px solid rgba(240,192,64,.3);
                                  padding:4px 12px;border-radius:5px;font-size:11px;text-decoration:none;
                                  font-family:var(--mono);margin-right:6px;">Editar</a>
                        @if($u->id !== auth()->id())
                        <form id="del-u-{{ $u->id }}" action="{{ route('admin.usuarios.destroy', $u) }}"
                              method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="button"
                                onclick="confirmar('del-u-{{ $u->id }}', '{{ $u->name }}')"
                                style="background:rgba(248,113,113,.12);color:#f87171;border:1px solid rgba(248,113,113,.25);
                                       padding:4px 12px;border-radius:5px;font-size:11px;cursor:pointer;font-family:var(--mono);">
                                Eliminar
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="empty">No hay usuarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;display:flex;justify-content:flex-end">{{ $usuarios->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
function confirmar(formId, nombre) {
    if (confirm('¿Eliminar al usuario "' + nombre + '"?\nEsta acción no se puede deshacer.')) {
        document.getElementById(formId).submit();
    }
}
</script>
@endpush