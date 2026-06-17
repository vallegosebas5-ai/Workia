<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Postulantes - {{ $oferta->titulo }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; margin: 30px; }
        h1 { font-size: 18px; color: #1a56db; margin-bottom: 4px; }
        .subtitle { color: #666; font-size: 12px; margin-bottom: 20px; }
        .info-box { background: #f3f4f6; padding: 10px 14px; border-radius: 6px; margin-bottom: 20px; }
        .info-box table { width: 100%; border-collapse: collapse; }
        .info-box td { padding: 3px 6px; font-size: 11px; }
        .info-box td:first-child { font-weight: bold; color: #374151; width: 140px; }
        table.postulantes { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.postulantes th { background: #1a56db; color: #fff; padding: 7px 8px; font-size: 10px; text-align: left; }
        table.postulantes td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; font-size: 10px; vertical-align: top; }
        table.postulantes tr:nth-child(even) { background: #f9fafb; }
        .badge { display: inline-block; padding: 2px 7px; border-radius: 10px; font-size: 9px; font-weight: bold; }
        .badge-pendiente { background: #e5e7eb; color: #374151; }
        .badge-revision { background: #dbeafe; color: #1e40af; }
        .badge-aceptado { background: #d1fae5; color: #065f46; }
        .badge-rechazado { background: #fee2e2; color: #991b1b; }
        .badge-entrevista { background: #ede9fe; color: #5b21b6; }
        .badge-prueba { background: #fef3c7; color: #92400e; }
        .footer { margin-top: 30px; font-size: 9px; color: #9ca3af; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .logo { font-size: 20px; font-weight: bold; color: #1a56db; }
        .logo span { color: #0e9f6e; }
    </style>
</head>
<body>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px">
        <div class="logo">Work<span>ia</span></div>
        <div style="color:#666;font-size:10px">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <h1>Reporte de postulantes</h1>
    <div class="subtitle">Oferta: {{ $oferta->titulo }}</div>

    <div class="info-box">
        <table>
            <tr><td>Empresa:</td><td>{{ $oferta->empresa->razon_social }}</td><td>Categoría:</td><td>{{ $oferta->categoria->nombre }}</td></tr>
            <tr><td>Tipo contrato:</td><td>{{ ucfirst(str_replace('_',' ',$oferta->tipo_contrato)) }}</td><td>Modalidad:</td><td>{{ ucfirst($oferta->modalidad) }}</td></tr>
            <tr><td>Total postulantes:</td><td><strong>{{ $postulaciones->count() }}</strong></td><td>Estado oferta:</td><td>{{ ucfirst($oferta->estado) }}</td></tr>
        </table>
    </div>

    <table class="postulantes">
        <thead>
            <tr>
                <th>#</th>
                <th>Candidato</th>
                <th>Educación</th>
                <th>Ciudad</th>
                <th>Fecha postulación</th>
                <th>Estado</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postulaciones as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    <strong>{{ $p->candidato->name }}</strong><br>
                    <span style="color:#6b7280">{{ $p->candidato->email }}</span>
                </td>
                <td>
                    {{ $p->candidato->perfil?->nivel_educacion ?? '-' }}
                    @if($p->candidato->perfil?->carrera)<br><span style="color:#6b7280">{{ $p->candidato->perfil->carrera }}</span>@endif
                </td>
                <td>{{ $p->candidato->perfil?->ciudad ?? $p->candidato->ciudad ?? '-' }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td><span class="badge badge-{{ $p->estado }}">{{ ucfirst($p->estado) }}</span></td>
                <td>{{ $p->nota_prueba !== null ? $p->nota_prueba . '/100' : '-' }}</td>
            </tr>
            @if($p->carta_presentacion)
            <tr>
                <td></td>
                <td colspan="6" style="color:#555;font-style:italic;font-size:9px;padding-top:2px;padding-bottom:4px">
                    {{ Str::limit($p->carta_presentacion, 150) }}
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <div class="footer">Workia Bolivia · Plataforma de empleos · Reporte generado automáticamente</div>
</body>
</html>
