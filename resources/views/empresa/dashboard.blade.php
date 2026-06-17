@extends('layouts.panel')
@section('title', 'Panel Empresa')
@section('sidebar-links')
<li><a href="{{ route('empresa.dashboard') }}" class="{{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('empresa.ofertas') }}" class="{{ request()->routeIs('empresa.ofertas*') ? 'active' : '' }}"><i class="fas fa-briefcase"></i> Mis ofertas</a></li>
<li><a href="{{ route('empresa.ofertas.crear') }}"><i class="fas fa-plus-circle"></i> Nueva oferta</a></li>
<li><a href="{{ route('empresa.perfil') }}" class="{{ request()->routeIs('empresa.perfil') ? 'active' : '' }}"><i class="fas fa-building"></i> Perfil empresa</a></li>
@endsection
@section('panel-content')
<div class="page-header">
    <div>
        <h1>{{ $empresa->razon_social }}</h1>
        <p>Panel de empresa · {{ $empresa->verificada ? '✅ Verificada' : '⏳ Pendiente verificación' }}</p>
    </div>
    <a href="{{ route('empresa.ofertas.crear') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva oferta</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-briefcase"></i></div>
        <div class="stat-value">{{ $totalOfertas }}</div>
        <div class="stat-label">Total ofertas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-circle"></i></div>
        <div class="stat-value">{{ $ofertasActivas }}</div>
        <div class="stat-label">Activas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-users"></i></div>
        <div class="stat-value">{{ $totalPostulantes }}</div>
        <div class="stat-label">Postulantes totales</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-bell"></i></div>
        <div class="stat-value">{{ $nuevasPostulaciones }}</div>
        <div class="stat-label">Nuevas postulaciones</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span><i class="fas fa-briefcase"></i> Mis ofertas recientes</span>
        <a href="{{ route('empresa.ofertas') }}" class="btn btn-outline btn-sm">Ver todas</a>
    </div>
    <div style="overflow-x:auto">
        <table class="table">
            <thead><tr><th>Oferta</th><th>Categoría</th><th>Postulantes</th><th>Estado</th><th>Acciones</th></tr></thead>
            <tbody>
                @forelse($ofertas as $o)
                <tr>
                    <td><div style="font-weight:600">{{ $o->titulo }}</div><small style="color:#6b7280">{{ $o->created_at->format('d/m/Y') }}</small></td>
                    <td><span class="badge badge-primary">{{ $o->categoria->nombre }}</span></td>
                    <td><span style="font-weight:700">{{ $o->postulaciones_count }}</span></td>
                    <td>
                        @if($o->estado === 'activa') <span class="badge badge-success">Activa</span>
                        @elseif($o->estado === 'pausada') <span class="badge badge-warning">Pausada</span>
                        @else <span class="badge badge-secondary">Cerrada</span> @endif
                    </td>
                    <td>
                        <a href="{{ route('empresa.postulantes', $o) }}" class="btn btn-primary btn-sm"><i class="fas fa-users"></i> Ver postulantes</a>
                        <a href="{{ route('empresa.ofertas.editar', $o) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:2rem;color:#6b7280">No has publicado ofertas. <a href="{{ route('empresa.ofertas.crear') }}" style="color:#1a56db">¡Crea tu primera oferta!</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
