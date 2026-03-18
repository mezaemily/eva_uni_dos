@extends('dash.app')
@section('title', 'Equipos')
@section('page-slug', 'equipos')
@section('page-title', 'Equipos')
@section('page-desc', 'Gestión de equipos')

@section('content')
@include('admin.partials.alerts')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div style="font-family:var(--mono);font-size:13px;color:var(--muted2);">{{ $equipos->total() }} equipos</div>
    <a href="{{ route('admin.equipos.create') }}"
       style="background:var(--accent);color:#000;padding:8px 18px;border-radius:6px;font-family:var(--mono);font-size:12px;font-weight:600;text-decoration:none;">
        + Nuevo Equipo
    </a>
</div>
<div class="card">
    <div class="tw">
        <table>
            <thead><tr><th>#</th><th>Equipo</th><th>Deporte</th><th>Fortaleza</th><th>Creado</th><th style="text-align:center">Acciones</th></tr></thead>
            <tbody>
                @forelse($equipos as $e)
                <tr>
                    <td class="cm">{{ $e->id }}</td>
                    <td style="font-weight:500">{{ $e->name }}</td>
                    <td><span class="b scheduled">{{ $e->sport->name ?? '-' }}</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:60px;height:4px;background:var(--bg3);border-radius:2px;overflow:hidden;">
                                <div style="height:100%;width:{{ $e->strength }}%;background:var(--accent);border-radius:2px;"></div>
                            </div>
                            <span class="cm">{{ $e->strength }}</span>
                        </div>
                    </td>
                    <td class="cm">{{ $e->created_at?->format('d/m/Y') }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admin.equipos.edit', $e) }}"
                           style="background:rgba(240,192,64,.15);color:var(--accent);border:1px solid rgba(240,192,64,.3);padding:4px 12px;border-radius:5px;font-size:11px;text-decoration:none;font-family:var(--mono);margin-right:6px;">Editar</a>
                        <form id="del-e-{{ $e->id }}" action="{{ route('admin.equipos.destroy', $e) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmar('del-e-{{ $e->id }}', '{{ $e->name }}')"
                                style="background:rgba(248,113,113,.12);color:#f87171;border:1px solid rgba(248,113,113,.25);padding:4px 12px;border-radius:5px;font-size:11px;cursor:pointer;font-family:var(--mono);">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="empty">No hay equipos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;display:flex;justify-content:flex-end">{{ $equipos->links() }}</div>
</div>
@endsection
@push('scripts')
<script>
function confirmar(formId, nombre) {
    if (confirm('¿Eliminar "' + nombre + '"?\nEsta acción no se puede deshacer.')) {
        document.getElementById(formId).submit();
    }
}
</script>
@endpush