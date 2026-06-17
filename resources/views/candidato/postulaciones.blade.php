@extends('layouts.panel')
@section('title', 'Mis Postulaciones')
@section('sidebar-links')
<li><a href="{{ route('candidato.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('candidato.perfil') }}"><i class="fas fa-user-edit"></i> Mi perfil</a></li>
<li><a href="{{ route('candidato.postulaciones') }}" class="active"><i class="fas fa-file-alt"></i> Mis postulaciones</a></li>
<li><a href="{{ route('ofertas.index') }}"><i class="fas fa-search"></i> Buscar empleos</a></li>
@endsection
@section('panel-content')
<div class="page-header">
    <div><h1>Mis postulaciones</h1><p>Seguimiento de tus aplicaciones laborales</p></div>
    <a href="{{ route('ofertas.index') }}" class="btn btn-primary"><i class="fas fa-search"></i> Buscar más empleos</a>
</div>

<div class="card">
    <div style="overflow-x:auto">
        <table class="table">
            <thead><tr><th>Oferta</th><th>Empresa</th><th>Categoría</th><th>Postulado</th><th>Estado</th><th>Nota</th></tr></thead>
            <tbody>
                @forelse($postulaciones as $p)
                <tr>
                    <td>
                        <a href="{{ route('ofertas.show', $p->oferta) }}" style="color:#1a56db;font-weight:600">{{ $p->oferta->titulo }}</a>
                        <div style="font-size:.78rem;color:#6b7280">{{ ucfirst(str_replace('_',' ',$p->oferta->tipo_contrato)) }}</div>
                    </td>
                    <td>
                        <div style="font-weight:500">{{ $p->oferta->empresa->razon_social }}</div>
                        <div style="font-size:.78rem;color:#6b7280">{{ $p->oferta->ubicacion }}</div>
                    </td>
                    <td><span class="badge badge-primary">{{ $p->oferta->categoria->nombre }}</span></td>
                    <td style="font-size:.83rem;color:#6b7280">{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>@include('partials.estado-badge', ['estado' => $p->estado])</td>
                    <td>
                        @if($p->nota_prueba !== null)
                            <span style="font-weight:700;color:{{ $p->nota_prueba >= 60 ? '#0e9f6e' : '#e02424' }}">{{ $p->nota_prueba }}/100</span>
                        @else
                            <span style="color:#9ca3af">-</span>
                        @endif
                    </td>
                </tr>
                @if($p->estado === 'entrevista' && $p->fecha_entrevista)
                <tr style="background:#f0fdf4">
                    <td colspan="6" style="font-size:.82rem;color:#065f46;padding:.5rem .9rem">
                        <i class="fas fa-calendar-check"></i> Entrevista programada para: <strong>{{ $p->fecha_entrevista->format('d/m/Y H:i') }}</strong>
                        @if($p->observaciones) · {{ $p->observaciones }} @endif
                    </td>
                </tr>
                @endif
                @empty
                <tr><td colspan="6" style="text-align:center;padding:3rem;color:#6b7280">
                    <i class="fas fa-file-alt" style="font-size:2.5rem;color:#d1d5db;display:block;margin-bottom:.75rem"></i>
                    Aún no te has postulado a ninguna oferta. <a href="{{ route('ofertas.index') }}" style="color:#1a56db">¡Empieza ahora!</a>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $postulaciones->links('partials.pagination') }}
@endsection
