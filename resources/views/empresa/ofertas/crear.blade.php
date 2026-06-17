@extends('layouts.panel')
@section('title', 'Nueva Oferta')
@section('sidebar-links')
<li><a href="{{ route('empresa.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('empresa.ofertas') }}"><i class="fas fa-briefcase"></i> Mis ofertas</a></li>
<li><a href="{{ route('empresa.ofertas.crear') }}" class="active"><i class="fas fa-plus-circle"></i> Nueva oferta</a></li>
<li><a href="{{ route('empresa.perfil') }}"><i class="fas fa-building"></i> Perfil empresa</a></li>
@endsection
@section('panel-content')
<div class="page-header"><div><h1>Publicar nueva oferta</h1><p>Completa los datos de la vacante</p></div></div>

<div class="card" style="max-width:800px">
    <div class="card-body">
        <form method="POST" action="{{ route('empresa.ofertas.guardar') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Título del puesto *</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}" class="form-control" required placeholder="Ej: Desarrollador Full Stack">
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Categoría *</label>
                    <select name="categoria_id" class="form-control" required>
                        <option value="">Seleccionar...</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Ubicación</label>
                    <input type="text" name="ubicacion" value="{{ old('ubicacion') }}" class="form-control" placeholder="Ej: La Paz, Bolivia">
                </div>
                <div class="form-group">
                    <label class="form-label">Tipo de contrato *</label>
                    <select name="tipo_contrato" class="form-control" required>
                        <option value="tiempo_completo">Tiempo completo</option>
                        <option value="medio_tiempo">Medio tiempo</option>
                        <option value="freelance">Freelance</option>
                        <option value="practicante">Practicante</option>
                        <option value="temporal">Temporal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Modalidad *</label>
                    <select name="modalidad" class="form-control" required>
                        <option value="presencial">Presencial</option>
                        <option value="remoto">Remoto</option>
                        <option value="hibrido">Híbrido</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Salario mínimo (Bs.)</label>
                    <input type="number" name="salario_min" value="{{ old('salario_min') }}" class="form-control" placeholder="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Salario máximo (Bs.)</label>
                    <input type="number" name="salario_max" value="{{ old('salario_max') }}" class="form-control" placeholder="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Vacantes disponibles *</label>
                    <input type="number" name="vacantes" value="{{ old('vacantes', 1) }}" class="form-control" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha límite</label>
                    <input type="date" name="fecha_limite" value="{{ old('fecha_limite') }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Descripción del puesto *</label>
                <textarea name="descripcion" class="form-control" rows="7" required placeholder="Describe las responsabilidades, el entorno de trabajo, beneficios...">{{ old('descripcion') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Requisitos</label>
                <textarea name="requisitos" class="form-control" rows="5" placeholder="Experiencia mínima, habilidades técnicas, conocimientos requeridos...">{{ old('requisitos') }}</textarea>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem">
                    <input type="checkbox" name="requiere_cv" value="1" {{ old('requiere_cv', true) ? 'checked' : '' }}> Requerir CV al postular
                </label>
            </div>
            <div style="display:flex;gap:.75rem">
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Publicar oferta</button>
                <a href="{{ route('empresa.ofertas') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
