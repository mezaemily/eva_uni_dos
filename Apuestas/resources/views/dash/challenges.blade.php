@extends('dash.app')
@section('title',     'Desafíos — Admin')
@section('page-slug', 'desafios')
@section('page-title','Desafíos')
@section('page-desc', 'retos entre usuarios')

@section('content')

<div class="grid-4">
    <div class="sc y"><div class="sc-dot"></div>
        <div class="sc-label">Total</div><div class="sc-value">{{ $stats['total'] }}</div>
    </div>
    <div class="sc b"><div class="sc-dot"></div>
        <div class="sc-label">Pendientes</div><div class="sc-value">{{ $stats['pending'] }}</div>
    </div>
    <div class="sc g"><div class="sc-dot"></div>
        <div class="sc-label">Aceptados</div><div class="sc-value">{{ $stats['accepted'] }}</div>
    </div>
    <div class="sc r"><div class="sc-dot"></div>
        <div class="sc-label">Completados</div><div class="sc-value">{{ $stats['completed'] }}</div>
    </div>
</div>

<div class="card gap">
    <div class="card-title">// todos los desafíos</div>
    <div class="tw">
        <table>
            <thead><tr>
                <th>#</th><th>Creador</th><th>Rival</th><th>Estado</th>
                <th>Apuestas</th><th>Fecha</th>
            </tr></thead>
            <tbody>
            @foreach($challenges as $ch)
            <tr>
                <td class="cm">{{ $ch->id }}</td>
                <td>
                    <span style="font-weight:500;">{{ $ch->creator->name ?? '-' }}</span>
                    <span class="cm" style="margin-left:4px;">(@{{ $ch->creator->username ?? '' }})</span>
                </td>
                <td>
                    <span style="font-weight:500;">{{ $ch->opponent->name ?? '-' }}</span>
                    <span class="cm" style="margin-left:4px;">(@{{ $ch->opponent->username ?? '' }})</span>
                </td>
                <td><span class="b {{ $ch->status }}">{{ $ch->status }}</span></td>
                <td class="cm">{{ $ch->challengeBets->count() }}</td>
                <td class="cm">{{ $ch->created_at?->format('d/m H:i') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        {{ $challenges->links() }}
    </div>
</div>

@endsection