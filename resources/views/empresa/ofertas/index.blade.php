@extends('layouts.panel')
@section('title', 'Mis Ofertas')
@section('sidebar-links')
<li><a href="{{ route('empresa.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('empresa.ofertas') }}" class="active"><i class="fas fa-briefcase"></i> Mis ofertas</a></li>
<li><a href="{{ route('empresa.ofertas.crear') }}"><i class="fas fa-plus-circle"></i> Nueva oferta</a></li>
<li><a href="{{ route('empresa.perfil') }}"><i class="fas fa-building"></i> Perfil empresa</a></li>
@endsection
@section('panel-content')
<div class="page-header">
    <div><h1>Mis ofertas laborales</h1><p>Gestiona tus vacantes publicadas</p></div>
    <a href="{{ route('empresa.ofertas.crear') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva oferta</a>
</div>

<div class="card">
    <div style="overflow-x:auto">
        <table class="table">
            <thead><tr><th>Título</th><th>Categoría</th><th>Tipo</th><th>Postulantes</th><th>Estado</th><th>Acciones</th></tr></thead>
            <tbody>
                @forelse($ofertas as $o)
                <tr>
                    <td>
                        <div style="font-weight:600">{{ $o->titulo }}</div>
                        <small style="color:#6b7280">{{ $o->created_at->format('d/m/Y') }} · {{ $o->vacantes }} vacante(s)</small>
                    </td>
                    <td><span class="badge badge-primary">{{ $o->categoria->nombre }}</span></td>
                    <td style="font-size:.83rem">{{ ucfirst(str_replace('_',' ',$o->tipo_contrato)) }}</td>
                    <td style="font-weight:700;color:#1a56db">{{ $o->postulaciones_count }}</td>
                    <td>
                        @if($o->estado === 'activa') <span class="badge badge-success">Activa</span>
                        @elseif($o->estado === 'pausada') <span class="badge badge-warning">Pausada</span>
                        @else <span class="badge badge-secondary">Cerrada</span> @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.35rem;flex-wrap:wrap">
                            <a href="{{ route('empresa.postulantes', $o) }}" class="btn btn-primary btn-sm" title="Ver postulantes"><i class="fas fa-users"></i></a>
                            <a href="{{ route('empresa.prueba', $o) }}" class="btn btn-warning btn-sm" title="Gestionar prueba"><i class="fas fa-clipboard-check"></i></a>
                            <a href="{{ route('empresa.ofertas.pdf', $o) }}" class="btn btn-danger btn-sm" title="Exportar PDF"><i class="fas fa-file-pdf"></i></a>
                            <a href="{{ route('empresa.ofertas.editar', $o) }}" class="btn btn-secondary btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('empresa.ofertas.eliminar', $o) }}" onsubmit="return confirm('¿Eliminar esta oferta?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:3rem;color:#6b7280">
                    <i class="fas fa-briefcase" style="font-size:2.5rem;color:#d1d5db;display:block;margin-bottom:.75rem"></i>
                    Aún no has publicado ofertas. <a href="{{ route('empresa.ofertas.crear') }}" style="color:#1a56db">¡Crea la primera!</a>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $ofertas->links('partials.pagination') }}
@endsection
