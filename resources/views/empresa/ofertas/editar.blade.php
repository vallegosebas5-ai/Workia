@extends('layouts.panel')
@section('title', 'Editar Oferta')
@section('sidebar-links')
<li><a href="{{ route('empresa.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('empresa.ofertas') }}" class="active"><i class="fas fa-briefcase"></i> Mis ofertas</a></li>
<li><a href="{{ route('empresa.ofertas.crear') }}"><i class="fas fa-plus-circle"></i> Nueva oferta</a></li>
<li><a href="{{ route('empresa.perfil') }}"><i class="fas fa-building"></i> Perfil empresa</a></li>
@endsection
@section('panel-content')
<div class="page-header"><div><h1>Editar oferta</h1><p>Modifica los datos de la vacante</p></div></div>

<div class="card" style="max-width:800px">
    <div class="card-body">
        <form method="POST" action="{{ route('empresa.ofertas.actualizar', $oferta) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Título del puesto *</label>
                <input type="text" name="titulo" value="{{ old('titulo', $oferta->titulo) }}" class="form-control" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Categoría *</label>
                    <select name="categoria_id" class="form-control" required>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id', $oferta->categoria_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-control">
                        <option value="activa" {{ $oferta->estado === 'activa' ? 'selected' : '' }}>Activa</option>
                        <option value="pausada" {{ $oferta->estado === 'pausada' ? 'selected' : '' }}>Pausada</option>
                        <option value="cerrada" {{ $oferta->estado === 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipo de contrato *</label>
                    <select name="tipo_contrato" class="form-control" required>
                        @foreach(['tiempo_completo'=>'Tiempo completo','medio_tiempo'=>'Medio tiempo','freelance'=>'Freelance','practicante'=>'Practicante','temporal'=>'Temporal'] as $v=>$l)
                            <option value="{{ $v }}" {{ old('tipo_contrato', $oferta->tipo_contrato) === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Modalidad *</label>
                    <select name="modalidad" class="form-control" required>
                        @foreach(['presencial'=>'Presencial','remoto'=>'Remoto','hibrido'=>'Híbrido'] as $v=>$l)
                            <option value="{{ $v }}" {{ old('modalidad', $oferta->modalidad) === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Salario mínimo (Bs.)</label>
                    <input type="number" name="salario_min" value="{{ old('salario_min', $oferta->salario_min) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Salario máximo (Bs.)</label>
                    <input type="number" name="salario_max" value="{{ old('salario_max', $oferta->salario_max) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Vacantes *</label>
                    <input type="number" name="vacantes" value="{{ old('vacantes', $oferta->vacantes) }}" class="form-control" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha límite</label>
                    <input type="date" name="fecha_limite" value="{{ old('fecha_limite', $oferta->fecha_limite?->format('Y-m-d')) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Ubicación</label>
                    <input type="text" name="ubicacion" value="{{ old('ubicacion', $oferta->ubicacion) }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Descripción *</label>
                <textarea name="descripcion" class="form-control" rows="6" required>{{ old('descripcion', $oferta->descripcion) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Requisitos</label>
                <textarea name="requisitos" class="form-control" rows="5">{{ old('requisitos', $oferta->requisitos) }}</textarea>
            </div>
            <div style="display:flex;gap:.75rem">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar cambios</button>
                <a href="{{ route('empresa.ofertas') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
