@extends('layouts.panel')
@section('title', 'Panel Candidato')
@section('sidebar-links')
<li><a href="{{ route('candidato.dashboard') }}" class="{{ request()->routeIs('candidato.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('candidato.perfil') }}" class="{{ request()->routeIs('candidato.perfil') ? 'active' : '' }}"><i class="fas fa-user-edit"></i> Mi perfil</a></li>
<li><a href="{{ route('candidato.postulaciones') }}" class="{{ request()->routeIs('candidato.postulaciones') ? 'active' : '' }}"><i class="fas fa-file-alt"></i> Mis postulaciones</a></li>
<li><a href="{{ route('ofertas.index') }}"><i class="fas fa-search"></i> Buscar empleos</a></li>
@endsection
@section('panel-content')
<div class="page-header">
    <div>
        <h1>Bienvenido, {{ auth()->user()->name }}</h1>
        <p>Panel de candidato - Gestiona tu perfil y postulaciones</p>
    </div>
    <a href="{{ route('ofertas.index') }}" class="btn btn-primary"><i class="fas fa-search"></i> Buscar empleos</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-file-alt"></i></div>
        <div class="stat-value">{{ $postulaciones->total() }}</div>
        <div class="stat-label">Total postulaciones</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
        <div class="stat-value">{{ $postulaciones->where('estado','pendiente')->count() }}</div>
        <div class="stat-label">En revisión</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-value">{{ $postulaciones->where('estado','aceptado')->count() }}</div>
        <div class="stat-label">Aceptadas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-value">{{ $postulaciones->where('estado','entrevista')->count() }}</div>
        <div class="stat-label">Entrevistas</div>
    </div>
</div>

@if(!$perfil->cv || !$perfil->resumen_profesional)
<div class="alert alert-info" style="margin-bottom:1.5rem">
    <i class="fas fa-info-circle"></i>
    Tu perfil está incompleto. <a href="{{ route('candidato.perfil') }}" style="color:#1e429f;font-weight:600">Complétalo ahora</a> para destacar ante los empleadores.
</div>
@endif

<div class="card">
    <div class="card-header">
        <span><i class="fas fa-history"></i> Últimas postulaciones</span>
        <a href="{{ route('candidato.postulaciones') }}" class="btn btn-outline btn-sm">Ver todas</a>
    </div>
    <div style="overflow-x:auto">
        <table class="table">
            <thead><tr><th>Oferta</th><th>Empresa</th><th>Fecha</th><th>Estado</th></tr></thead>
            <tbody>
                @forelse($postulaciones as $p)
                <tr>
                    <td><a href="{{ route('ofertas.show', $p->oferta) }}" style="color:#1a56db;font-weight:600">{{ $p->oferta->titulo }}</a></td>
                    <td>{{ $p->oferta->empresa->razon_social }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>@include('partials.estado-badge', ['estado' => $p->estado])</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#6b7280;padding:2rem">Aún no te has postulado a ninguna oferta. <a href="{{ route('ofertas.index') }}" style="color:#1a56db">¡Busca empleos!</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
