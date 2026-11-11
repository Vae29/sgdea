@props(['type' => 'info', 'title' => null, 'dismissible' => false])
@php $icons = ['success' => 'check-circle', 'warning' => 'alert-triangle', 'error' => 'alert-circle', 'info' => 'info']; @endphp
<div {{ $attributes->merge(['class' => 'alert alert-' . $type, 'role' => $type === 'error' ? 'alert' : 'status']) }}>
    <x-sgdea.icon :name="$icons[$type] ?? 'info'" />
    <div class="alert-body">@if ($title)<strong>{{ $title }}</strong>@endif{{ $slot }}</div>
    @if ($dismissible)<button type="button" class="alert-close" data-dismiss aria-label="Cerrar"><x-sgdea.icon name="x" :size="16" /></button>@endif
</div>
