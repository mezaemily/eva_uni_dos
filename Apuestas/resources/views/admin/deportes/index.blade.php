@extends('dash.app')
@section('title', 'Deportes')
@section('page-slug', 'deportes')
@section('page-title', 'Deportes')
@section('page-desc', 'Gestión de deportes')

@section('content')
@include('admin.partials.alerts')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div style="font-family:var(--mono);font-size:13px;color:var(--muted2);">{{ $deportes->total() }} deportes</div>
    <a href="{{ route('admin.deportes.create') }}"
       style="background:var(--accent);color:#000;padding:8px 18px;border-radius:6px;font-family:var(--mono);font-size:12px;font-weight:600;text-decoration:none;">
        + Nuevo Deporte
    </a>
</div>
<div class="card">
    <div class="tw">
        <table>
            <thead><tr><th>#</th><th>Nombre</th><th>Equipos</th><th>Creado</th><th style="text-align:center">Acciones</th></tr></thead>
            <tbody>
                @forelse($deportes as $d)
                <tr>
                    <td class="cm">{{ $d->id }}</td>
                    <td style="font-weight:500">{{ $d->name }}</td>
                    <td class="cm">{{ $d->teams_count }}</td>
                    <td class="cm">{{ $d->created_at?->format('d/m/Y') }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admin.deportes.edit', $d) }}"
                           style="background:rgba(240,192,64,.15);color:var(--accent);border:1px solid rgba(240,192,64,.3);padding:4px 12px;border-radius:5px;font-size:11px;text-decoration:none;font-family:var(--mono);margin-right:6px;">Editar</a>
                        <form id="del-d-{{ $d->id }}" action="{{ route('admin.deportes.destroy', $d) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmar('del-d-{{ $d->id }}', '{{ $d->name }}')"
                                style="background:rgba(248,113,113,.12);color:#f87171;border:1px solid rgba(248,113,113,.25);padding:4px 12px;border-radius:5px;font-size:11px;cursor:pointer;font-family:var(--mono);">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="empty">No hay deportes registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;display:flex;justify-content:flex-end">{{ $deportes->links() }}</div>
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