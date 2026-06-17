@extends('layouts.panel')
@section('title', 'Empresas - Admin')
@section('sidebar-links')
<li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
<li><a href="{{ route('admin.usuarios') }}"><i class="fas fa-users"></i> Usuarios</a></li>
<li><a href="{{ route('admin.empresas') }}" class="active"><i class="fas fa-building"></i> Empresas</a></li>
<li><a href="{{ route('admin.ofertas') }}"><i class="fas fa-briefcase"></i> Ofertas</a></li>
<li><a href="{{ route('admin.categorias') }}"><i class="fas fa-tags"></i> Categorías</a></li>
@endsection
@section('panel-content')
<div class="page-header"><div><h1>Gestión de empresas</h1><p>{{ $empresas->total() }} empresas registradas</p></div></div>

<div class="card">
    <div style="overflow-x:auto">
        <table class="table">
            <thead><tr><th>Empresa</th><th>Rubro</th><th>Ciudad</th><th>Ofertas</th><th>Verificada</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($empresas as $e)
                <tr>
                    <td>
                        <div style="font-weight:600">{{ $e->razon_social }}</div>
                        <div style="font-size:.78rem;color:#6b7280">{{ $e->user->email }}</div>
                    </td>
                    <td style="font-size:.83rem">{{ $e->rubro ?? '-' }}</td>
                    <td style="font-size:.83rem">{{ $e->ciudad ?? '-' }}</td>
                    <td style="font-weight:700;color:#1a56db">{{ $e->ofertas_count }}</td>
                    <td>{!! $e->verificada ? '<span class="badge badge-success"><i class="fas fa-check"></i> Verificada</span>' : '<span class="badge badge-warning">Pendiente</span>' !!}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.empresas.verificar', $e) }}">
                            @csrf @method('PUT')
                            <button class="btn btn-sm {{ $e->verificada ? 'btn-secondary' : 'btn-success' }}">
                                <i class="fas fa-{{ $e->verificada ? 'times' : 'check' }}"></i> {{ $e->verificada ? 'Quitar verificación' : 'Verificar' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $empresas->links('partials.pagination') }}
@endsection
