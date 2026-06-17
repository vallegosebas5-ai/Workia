@extends('layouts.panel')
@section('title', 'Categorías - Admin')
@section('sidebar-links')
<li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
<li><a href="{{ route('admin.usuarios') }}"><i class="fas fa-users"></i> Usuarios</a></li>
<li><a href="{{ route('admin.empresas') }}"><i class="fas fa-building"></i> Empresas</a></li>
<li><a href="{{ route('admin.ofertas') }}"><i class="fas fa-briefcase"></i> Ofertas</a></li>
<li><a href="{{ route('admin.categorias') }}" class="active"><i class="fas fa-tags"></i> Categorías</a></li>
@endsection
@section('panel-content')
<div class="page-header"><div><h1>Gestión de categorías</h1><p>Organiza las áreas de empleo del sistema</p></div></div>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start">
    <div class="card">
        <div class="card-header">Nueva categoría</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categorias.guardar') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="nombre" class="form-control" required placeholder="Ej: Tecnología">
                </div>
                <div class="form-group">
                    <label class="form-label">Icono Font Awesome</label>
                    <input type="text" name="icono" class="form-control" placeholder="laptop-code">
                    <small style="color:#6b7280;font-size:.75rem">Solo el nombre del icono: <code>briefcase</code>, <code>code</code>, etc.</small>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Crear categoría</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Categorías existentes</div>
        <div style="overflow-x:auto">
            <table class="table">
                <thead><tr><th>Icono</th><th>Nombre</th><th>Ofertas</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @foreach($categorias as $cat)
                    <tr>
                        <td style="text-align:center"><i class="fas fa-{{ $cat->icono ?? 'briefcase' }}" style="color:#1a56db;font-size:1.1rem"></i></td>
                        <td style="font-weight:500">{{ $cat->nombre }}</td>
                        <td style="font-weight:700;color:#1a56db">{{ $cat->ofertas_count }}</td>
                        <td>{!! $cat->activo ? '<span class="badge badge-success">Activa</span>' : '<span class="badge badge-secondary">Inactiva</span>' !!}</td>
                        <td>
                            <div style="display:flex;gap:.35rem">
                                <button onclick="editCat({{ $cat->id }}, '{{ $cat->nombre }}', '{{ $cat->icono }}')" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></button>
                                @if($cat->ofertas_count === 0)
                                <form method="POST" action="{{ route('admin.categorias.eliminar', $cat) }}" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal editar categoría -->
<div id="modal-cat" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center">
    <div class="card" style="max-width:400px;width:90%">
        <div class="card-header">Editar categoría <button onclick="document.getElementById('modal-cat').style.display='none'" style="background:none;border:none;cursor:pointer;font-size:1.2rem;color:#6b7280;margin-left:auto">&times;</button></div>
        <div class="card-body">
            <form id="form-cat" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="cat-nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Icono</label>
                    <input type="text" name="icono" id="cat-icono" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
function editCat(id, nombre, icono) {
    document.getElementById('form-cat').action = '{{ url("admin/categorias") }}/' + id;
    document.getElementById('cat-nombre').value = nombre;
    document.getElementById('cat-icono').value = icono || '';
    document.getElementById('modal-cat').style.display = 'flex';
}
</script>
@endsection
