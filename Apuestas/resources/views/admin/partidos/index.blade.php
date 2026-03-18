@extends('dash.app')
@section('title', 'Partidos')
@section('page-slug', 'partidos')
@section('page-title', 'Partidos')
@section('page-desc', 'Gestión de partidos')

@section('content')
@include('admin.partials.alerts')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div style="font-family:var(--mono);font-size:13px;color:var(--muted2);">{{ $partidos->total() }} partidos</div>
    <a href="{{ route('admin.partidos.create') }}"
       style="background:var(--accent);color:#000;padding:8px 18px;border-radius:6px;font-family:var(--mono);font-size:12px;font-weight:600;text-decoration:none;">
        + Nuevo Partido
    </a>
</div>
<div class="card">
    <div class="tw">
        <table>
            <thead><tr><th>#</th><th>Deporte</th><th>Local</th><th>Visitante</th><th>Marcador</th><th>Fecha</th><th>Apuestas</th><th>Estado</th><th style="text-align:center">Acciones</th></tr></thead>
            <tbody>
                @forelse($partidos as $p)
                <tr>
                    <td class="cm">{{ $p->id }}</td>
                    <td class="cm">{{ $p->sport->name ?? '-' }}</td>
                    <td style="font-weight:500">{{ $p->teamHome->name ?? '-' }}</td>
                    <td style="font-weight:500">{{ $p->teamAway->name ?? '-' }}</td>
                    <td class="cy">
                        @if(!is_null($p->home_score)) {{ $p->home_score }} — {{ $p->away_score }}
                        @else <span class="cm">—</span> @endif
                    </td>
                    <td class="cm">{{ $p->match_date?->format('d/m/Y H:i') }}</td>
                    <td class="cm">{{ $p->bets_count }}</td>
                    <td><span class="b {{ $p->status }}">{{ $p->status }}</span></td>
                    <td style="text-align:center">
                        <a href="{{ route('admin.partidos.edit', $p) }}"
                           style="background:rgba(240,192,64,.15);color:var(--accent);border:1px solid rgba(240,192,64,.3);padding:4px 12px;border-radius:5px;font-size:11px;text-decoration:none;font-family:var(--mono);margin-right:6px;">Editar</a>
                        <form id="del-p-{{ $p->id }}" action="{{ route('admin.partidos.destroy', $p) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="button"
                                onclick="confirmar('del-p-{{ $p->id }}', '{{ $p->teamHome->name ?? '' }} vs {{ $p->teamAway->name ?? '' }}')"
                                style="background:rgba(248,113,113,.12);color:#f87171;border:1px solid rgba(248,113,113,.25);padding:4px 12px;border-radius:5px;font-size:11px;cursor:pointer;font-family:var(--mono);">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="empty">No hay partidos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;display:flex;justify-content:flex-end">{{ $partidos->links() }}</div>
</div>
@endsection
@push('scripts')
<script>
function confirmar(formId, nombre) {
    if (confirm('¿Eliminar el partido "' + nombre + '"?\nEsta acción no se puede deshacer.')) {
        document.getElementById(formId).submit();
    }
}
</script>
@endpush