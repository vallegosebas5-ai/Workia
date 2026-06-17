@extends('layouts.panel')
@section('title', 'Panel Admin')
@section('sidebar-links')
<li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
<li><a href="{{ route('admin.usuarios') }}" class="{{ request()->routeIs('admin.usuarios') ? 'active' : '' }}"><i class="fas fa-users"></i> Usuarios</a></li>
<li><a href="{{ route('admin.empresas') }}" class="{{ request()->routeIs('admin.empresas') ? 'active' : '' }}"><i class="fas fa-building"></i> Empresas</a></li>
<li><a href="{{ route('admin.ofertas') }}" class="{{ request()->routeIs('admin.ofertas') ? 'active' : '' }}"><i class="fas fa-briefcase"></i> Ofertas</a></li>
<li><a href="{{ route('admin.categorias') }}" class="{{ request()->routeIs('admin.categorias') ? 'active' : '' }}"><i class="fas fa-tags"></i> Categorías</a></li>
@endsection
@section('panel-content')
<div class="page-header">
    <div><h1>Panel de administración</h1><p>Resumen general de Workia Bolivia</p></div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
        <div class="stat-value">{{ $totalUsuarios }}</div>
        <div class="stat-label">Usuarios totales</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-building"></i></div>
        <div class="stat-value">{{ $totalEmpresas }}</div>
        <div class="stat-label">Empresas registradas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-briefcase"></i></div>
        <div class="stat-value">{{ $totalOfertas }}</div>
        <div class="stat-label">Total ofertas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-circle"></i></div>
        <div class="stat-value">{{ $ofertasActivas }}</div>
        <div class="stat-label">Ofertas activas</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
    <div class="card">
        <div class="card-header"><span><i class="fas fa-user-plus"></i> Usuarios recientes</span><a href="{{ route('admin.usuarios') }}" class="btn btn-outline btn-sm">Ver todos</a></div>
        <div style="overflow-x:auto">
            <table class="table">
                <thead><tr><th>Nombre</th><th>Rol</th><th>Estado</th></tr></thead>
                <tbody>
                    @foreach($usuariosRecientes as $u)
                    <tr>
                        <td><div style="font-weight:500">{{ $u->name }}</div><small style="color:#6b7280">{{ $u->email }}</small></td>
                        <td>
                            @if($u->role === 'admin') <span class="badge badge-danger">Admin</span>
                            @elseif($u->role === 'empresa') <span class="badge badge-info">Empresa</span>
                            @else <span class="badge badge-success">Candidato</span> @endif
                        </td>
                        <td>@if($u->activo) <span class="badge badge-success">Activo</span> @else <span class="badge badge-danger">Inactivo</span> @endif</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><span><i class="fas fa-briefcase"></i> Ofertas recientes</span><a href="{{ route('admin.ofertas') }}" class="btn btn-outline btn-sm">Ver todas</a></div>
        <div style="overflow-x:auto">
            <table class="table">
                <thead><tr><th>Oferta</th><th>Empresa</th><th>Estado</th></tr></thead>
                <tbody>
                    @foreach($ofertasRecientes as $o)
                    <tr>
                        <td style="font-size:.85rem;font-weight:500">{{ Str::limit($o->titulo,30) }}</td>
                        <td style="font-size:.83rem;color:#6b7280">{{ $o->empresa->razon_social }}</td>
                        <td>
                            @if($o->estado === 'activa') <span class="badge badge-success">Activa</span>
                            @elseif($o->estado === 'pausada') <span class="badge badge-warning">Pausada</span>
                            @else <span class="badge badge-secondary">Cerrada</span> @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
