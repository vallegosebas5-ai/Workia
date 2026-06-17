@extends('layouts.panel')
@section('title', 'Postulantes')
@section('sidebar-links')
<li><a href="{{ route('empresa.dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
<li><a href="{{ route('empresa.ofertas') }}" class="active"><i class="fas fa-briefcase"></i> Mis ofertas</a></li>
<li><a href="{{ route('empresa.ofertas.crear') }}"><i class="fas fa-plus-circle"></i> Nueva oferta</a></li>
<li><a href="{{ route('empresa.perfil') }}"><i class="fas fa-building"></i> Perfil empresa</a></li>
@endsection
@section('styles')
<style>
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center;padding:1rem}
.modal-overlay.open{display:flex}
</style>
@endsection
@section('panel-content')
<div class="page-header">
    <div>
        <h1>Postulantes: {{ $oferta->titulo }}</h1>
        <p>{{ $postulaciones->total() }} postulante(s) · <a href="{{ route('empresa.ofertas.pdf', $oferta) }}" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Exportar PDF</a></p>
    </div>
    <div style="display:flex;gap:.5rem">
        <a href="{{ route('empresa.prueba', $oferta) }}" class="btn btn-warning btn-sm"><i class="fas fa-clipboard-check"></i> Gestionar prueba</a>
        <a href="{{ route('empresa.ofertas') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
    </div>
</div>

<div class="card">
    <div style="overflow-x:auto">
        <table class="table">
            <thead><tr><th>Candidato</th><th>Educación</th><th>CV</th><th>Postulado</th><th>Estado</th><th>Nota</th><th>Acciones</th></tr></thead>
            <tbody>
                @forelse($postulaciones as $p)
                <tr>
                    <td>
                        <div style="font-weight:600">{{ $p->candidato->name }}</div>
                        <div style="font-size:.78rem;color:#6b7280">{{ $p->candidato->email }}</div>
                        @if($p->candidato->perfil?->ciudad)<small style="color:#6b7280"><i class="fas fa-map-marker-alt"></i> {{ $p->candidato->perfil->ciudad }}</small>@endif
                    </td>
                    <td style="font-size:.83rem">
                        {{ $p->candidato->perfil?->nivel_educacion ?? '-' }}
                        @if($p->candidato->perfil?->carrera)<div style="color:#6b7280;font-size:.78rem">{{ $p->candidato->perfil->carrera }}</div>@endif
                    </td>
                    <td>
                        @if($p->cv || $p->candidato->perfil?->cv)
                            <a href="{{ route('empresa.postulaciones.cv', $p) }}" target="_blank" class="btn btn-outline btn-sm"><i class="fas fa-file-pdf"></i> Ver CV</a>
                        @else
                            <span style="color:#9ca3af;font-size:.8rem">Sin CV</span>
                        @endif
                    </td>
                    <td style="font-size:.83rem;color:#6b7280">{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>@include('partials.estado-badge', ['estado' => $p->estado])</td>
                    <td>
                        @if($p->nota_prueba !== null)
                            <span style="font-weight:700;color:{{ $p->nota_prueba >= 60 ? '#0e9f6e' : '#e02424' }}">{{ $p->nota_prueba }}/100</span>
                        @else -  @endif
                    </td>
                    <td>
                        <button onclick="abrirModal({{ $p->id }}, '{{ $p->estado }}', '{{ $p->observaciones }}', '{{ $p->nota_prueba }}', '{{ $p->fecha_entrevista?->format('Y-m-d\TH:i') }}')" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Actualizar</button>
                    </td>
                </tr>
                @if($p->carta_presentacion)
                <tr style="background:#f9fafb">
                    <td colspan="7" style="font-size:.82rem;color:#374151;padding:.5rem .9rem;font-style:italic">
                        <i class="fas fa-comment" style="color:#6b7280"></i> {{ Str::limit($p->carta_presentacion, 200) }}
                    </td>
                </tr>
                @endif
                @empty
                <tr><td colspan="7" style="text-align:center;padding:3rem;color:#6b7280">Aún no hay postulantes para esta oferta.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $postulaciones->links('partials.pagination') }}

<!-- Modal actualizar estado -->
<div class="modal-overlay" id="modal-estado">
    <div class="card" style="max-width:480px;width:100%">
        <div class="card-header">Actualizar estado del postulante <button onclick="cerrarModal()" style="background:none;border:none;cursor:pointer;font-size:1.25rem;color:#6b7280;margin-left:auto">&times;</button></div>
        <div class="card-body">
            <form id="form-estado" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Estado</label>
                    <select name="estado" id="modal-estado-select" class="form-control">
                        <option value="pendiente">Pendiente</option>
                        <option value="revision">En revisión</option>
                        <option value="prueba">Enviar prueba</option>
                        <option value="entrevista">Confirmar entrevista</option>
                        <option value="aceptado">Aceptado</option>
                        <option value="rechazado">Rechazado</option>
                    </select>
                </div>
                <div class="form-group" id="group-nota" style="display:none">
                    <label class="form-label">Nota de prueba (0-100)</label>
                    <input type="number" name="nota_prueba" id="modal-nota" min="0" max="100" class="form-control">
                </div>
                <div class="form-group" id="group-entrevista" style="display:none">
                    <label class="form-label">Fecha y hora de entrevista</label>
                    <input type="datetime-local" name="fecha_entrevista" id="modal-fecha" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" id="modal-obs" class="form-control" rows="3"></textarea>
                </div>
                <div style="display:flex;gap:.5rem">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    <button type="button" onclick="cerrarModal()" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
const baseUrl = '{{ url("empresa/postulaciones") }}';
function abrirModal(id, estado, obs, nota, fecha) {
    document.getElementById('form-estado').action = baseUrl + '/' + id + '/estado';
    document.getElementById('modal-estado-select').value = estado;
    document.getElementById('modal-obs').value = obs !== 'null' ? obs : '';
    document.getElementById('modal-nota').value = nota !== 'null' ? nota : '';
    document.getElementById('modal-fecha').value = fecha !== 'null' ? fecha : '';
    toggleCampos(estado);
    document.getElementById('modal-estado').classList.add('open');
}
function cerrarModal() { document.getElementById('modal-estado').classList.remove('open'); }
function toggleCampos(val) {
    document.getElementById('group-nota').style.display = val === 'prueba' ? 'block' : 'none';
    document.getElementById('group-entrevista').style.display = val === 'entrevista' ? 'block' : 'none';
}
document.getElementById('modal-estado-select').addEventListener('change', e => toggleCampos(e.target.value));
</script>
@endsection
