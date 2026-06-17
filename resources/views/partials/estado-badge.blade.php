@php
$config = [
    'pendiente' => ['class' => 'badge-secondary', 'icon' => 'clock', 'label' => 'Pendiente'],
    'revision' => ['class' => 'badge-info', 'icon' => 'eye', 'label' => 'En revisión'],
    'prueba' => ['class' => 'badge-warning', 'icon' => 'clipboard-check', 'label' => 'Prueba enviada'],
    'entrevista' => ['class' => 'badge-primary', 'icon' => 'calendar-check', 'label' => 'Entrevista'],
    'aceptado' => ['class' => 'badge-success', 'icon' => 'check-circle', 'label' => 'Aceptado'],
    'rechazado' => ['class' => 'badge-danger', 'icon' => 'times-circle', 'label' => 'Rechazado'],
];
$c = $config[$estado] ?? ['class' => 'badge-secondary', 'icon' => 'question', 'label' => $estado];
@endphp
<span class="badge {{ $c['class'] }}"><i class="fas fa-{{ $c['icon'] }}"></i> {{ $c['label'] }}</span>
