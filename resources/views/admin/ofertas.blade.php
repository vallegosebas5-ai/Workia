@extends('layouts.panel')
@section('title', 'Ofertas - Admin')
@section('sidebar-links')
<li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
<li><a href="{{ route('admin.usuarios') }}"><i class="fas fa-users"></i> Usuarios</a></li>
<li><a href="{{ route('admin.empresas') }}"><i class="fas fa-building"></i> Empresas</a></li>
<li><a href="{{ route('admin.ofertas') }}" class="active"><i class="fas fa-briefcase"></i> Ofertas</a></li>
<li><a href="{{ route('admin.categorias') }}"><i class="fas fa-tags"></i> Categorías</a></li>
@endsection
@section('panel-content')
<div class="page-header"><div><h1>Gestión de ofertas</h1><p>{{ $ofertas->total() }} ofertas en el sistema</p></div></div>

<div class="card" style="margin-bottom:1rem">
    <div class="card-body" style="padding:.75rem 1.25rem">
        <form method="GET" action="{{ route('admin.ofertas') }}" style="display:flex;gap:.75rem">
            <select name="estado" class="form-control" style="max-width:180px" onchange="this.form.submit()">
                <option value="">Todos los estados</option>
                <option value="activa" {{ request('estado') === 'activa' ? 'selected' : '' }}>Activas</option>
                <option value="pausada" {{ request('estado') === 'pausada' ? 'selected' : '' }}>Pausadas</option>
                <option value="cerrada" {{ request('estado') === 'cerrada' ? 'selected' : '' }}>Cerradas</option>
            </select>
            @if(request('estado'))<a href="{{ route('admin.ofertas') }}" class="btn btn-secondary btn-sm">Limpiar</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div style="overflow-x:auto">
        <table class="table">
            <thead><tr><th>Título</th><th>Empresa</th><th>Categoría</th><th>Publicada</th><th>Estado</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($ofertas as $o)
                <tr>
                    <td><div style="font-weight:500">{{ Str::limit($o->titulo,40) }}</div></td>
                    <td style="font-size:.83rem">{{ $o->empresa->razon_social }}</td>
                    <td><span class="badge badge-primary">{{ $o->categoria->nombre }}</span></td>
                    <td style="font-size:.83rem;color:#6b7280">{{ $o->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($o->estado === 'activa') <span class="badge badge-success">Activa</span>
                        @elseif($o->estado === 'pausada') <span class="badge badge-warning">Pausada</span>
                        @else <span class="badge badge-secondary">Cerrada</span> @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.35rem">
                            <form method="POST" action="{{ route('admin.ofertas.toggle', $o) }}">
                                @csrf @method('PUT')
                                <button class="btn btn-sm {{ $o->estado === 'activa' ? 'btn-warning' : 'btn-success' }}">
                                    <i class="fas fa-{{ $o->estado === 'activa' ? 'pause' : 'play' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.ofertas.eliminar', $o) }}" onsubmit="return confirm('¿Eliminar oferta?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $ofertas->links('partials.pagination') }}
@endsection
