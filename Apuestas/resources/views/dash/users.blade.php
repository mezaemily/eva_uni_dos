@extends('dash.app')
@section('title',     'Usuarios — Admin')
@section('page-slug', 'usuarios')
@section('page-title','Usuarios')
@section('page-desc', '{{ $users->total() }} registros')

@section('content')

<div class="grid-4">
    <div class="sc y"><div class="sc-dot"></div>
        <div class="sc-label">Total</div>
        <div class="sc-value">{{ $stats['total'] }}</div>
    </div>
    <div class="sc b"><div class="sc-dot"></div>
        <div class="sc-label">Jugadores</div>
        <div class="sc-value">{{ $stats['users'] }}</div>
    </div>
    <div class="sc r"><div class="sc-dot"></div>
        <div class="sc-label">Admins</div>
        <div class="sc-value">{{ $stats['admins'] }}</div>
    </div>
    <div class="sc g"><div class="sc-dot"></div>
        <div class="sc-label">Saldo total</div>
        <div class="sc-value">${{ number_format($stats['total_balance'],0) }}</div>
    </div>
</div>

<div class="card gap">
    <div class="card-title">// lista de usuarios</div>
    <div class="tw">
        <table>
            <thead><tr>
                <th>#</th><th>Nombre</th><th>Username</th><th>Email</th>
                <th>Saldo</th><th>Rol</th><th>Apuestas</th><th>Tx</th><th>Registro</th>
            </tr></thead>
            <tbody>
            @foreach($users as $u)
            <tr>
                <td class="cm">{{ $u->id }}</td>
                <td style="font-weight:500;">{{ $u->name }}</td>
                <td class="cm">@{{ $u->username }}</td>
                <td style="font-size:12px;color:var(--text2);">{{ $u->email }}</td>
                <td class="{{ $u->balance > 0 ? 'cg' : 'cr' }}">
                    ${{ number_format($u->balance,2) }}
                </td>
                <td><span class="b {{ $u->role }}">{{ $u->role }}</span></td>
                <td class="cm">{{ $u->bets_count }}</td>
                <td class="cm">{{ $u->transactions_count }}</td>
                <td class="cm">{{ $u->created_at?->format('d/m/Y') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        {{ $users->links() }}
    </div>
</div>

@endsection