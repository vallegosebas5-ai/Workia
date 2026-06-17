@extends('layouts.panel')
@section('title', 'Usuarios - Admin')
@section('sidebar-links')
<li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
<li><a href="{{ route('admin.usuarios') }}" class="active"><i class="fas fa-users"></i> Usuarios</a></li>
<li><a href="{{ route('admin.empresas') }}"><i class="fas fa-building"></i> Empresas</a></li>
<li><a href="{{ route('admin.ofertas') }}"><i class="fas fa-briefcase"></i> Ofertas</a></li>
<li><a href="{{ route('admin.categorias') }}"><i class="fas fa-tags"></i> Categorías</a></li>
@endsection
@section('panel-content')
<div class="page-header"><div><h1>Gestión de usuarios</h1><p>{{ $usuarios->total() }} usuarios registrados</p></div></div>

<div class="card" style="margin-bottom:1rem">
    <div class="card-body" style="padding:.75rem 1.25rem">
        <form method="GET" action="{{ route('admin.usuarios') }}" style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap">
            <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" style="max-width:250px" placeholder="Buscar por nombre o email...">
            <select name="rol" class="form-control" style="max-width:160px" onchange="this.form.submit()">
                <option value="">Todos los roles</option>
                <option value="candidato" {{ request('rol') === 'candidato' ? 'selected' : '' }}>Candidatos</option>
                <option value="empresa" {{ request('rol') === 'empresa' ? 'selected' : '' }}>Empresas</option>
                <option value="admin" {{ request('rol') === 'admin' ? 'selected' : '' }}>Admins</option>
            </select>
            <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>
            @if(request()->anyFilled(['buscar','rol']))<a href="{{ route('admin.usuarios') }}" class="btn btn-secondary btn-sm">Limpiar</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div style="overflow-x:auto">
        <table class="table">
            <thead><tr><th>Usuario</th><th>Rol</th><th>Ciudad</th><th>Registrado</th><th>Estado</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($usuarios as $u)
                <tr>
                    <td>
                        <div style="font-weight:600">{{ $u->name }}</div>
                        <div style="font-size:.78rem;color:#6b7280">{{ $u->email }}</div>
                    </td>
                    <td>
                        @if($u->role === 'admin') <span class="badge badge-danger">Admin</span>
                        @elseif($u->role === 'empresa') <span class="badge badge-info">Empresa</span>
                        @else <span class="badge badge-success">Candidato</span> @endif
                    </td>
                    <td style="font-size:.83rem">{{ $u->ciudad ?? '-' }}</td>
                    <td style="font-size:.83rem;color:#6b7280">{{ $u->created_at->format('d/m/Y') }}</td>
                    <td>{!! $u->activo ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>' !!}</td>
                    <td>
                        @if(!$u->isAdmin())
                        <div style="display:flex;gap:.35rem">
                            <form method="POST" action="{{ route('admin.usuarios.toggle', $u) }}">
                                @csrf @method('PUT')
                                <button class="btn btn-sm {{ $u->activo ? 'btn-warning' : 'btn-success' }}">
                                    <i class="fas fa-{{ $u->activo ? 'ban' : 'check' }}"></i> {{ $u->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.usuarios.eliminar', $u) }}" onsubmit="return confirm('¿Eliminar usuario?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                        @else
                        <span style="color:#9ca3af;font-size:.8rem">Admin principal</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $usuarios->links('partials.pagination') }}
@endsection
