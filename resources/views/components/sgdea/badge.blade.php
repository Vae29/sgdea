@props(['status' => null, 'tone' => 'neutral', 'label' => null, 'dot' => true])
@php
    $map = [
        'pendiente' => ['neutral', 'Pendiente'], 'proximo' => ['warning', 'Próximo a vencer'],
        'vencido' => ['danger', 'Vencido'], 'revision' => ['info', 'En revisión'],
        'aprobado' => ['success', 'Aprobado'], 'rechazado' => ['danger', 'Rechazado'],
        'transferido' => ['dark', 'Transferido'], 'vigente' => ['success', 'Vigente'],
        'activo' => ['success', 'Activo'], 'inactivo' => ['neutral', 'Inactivo'],
        'abierta' => ['info', 'Abierta'], 'cerrada' => ['dark', 'Cerrada'],
        'publica' => ['success', 'Pública'], 'clasificada' => ['warning', 'Clasificada'],
        'reservada' => ['danger', 'Reservada'], 'demo' => ['demo', 'Demostración'],
    ];
    [$t, $l] = $status && isset($map[$status]) ? $map[$status] : [$tone, $label];
    $l = $label ?? $l;
@endphp
<span {{ $attributes->merge(['class' => 'badge badge-' . $t . ($dot ? '' : ' no-dot')]) }}>{{ $l ?? $slot }}</span>
