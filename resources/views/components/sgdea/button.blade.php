@props(['variant' => 'primary', 'size' => 'md', 'icon' => null, 'href' => null, 'type' => 'button', 'route' => null, 'params' => []])
@php
    $classes = 'btn btn-' . $variant . ($size === 'sm' ? ' btn-sm' : '');
    $pending = null;
    if ($route) {
        if (\Illuminate\Support\Facades\Route::has($route)) { $href = route($route, $params); }
        else { $href = '#'; $pending = $route; }
    }
@endphp
@if ($href)
    <a href="{{ $href }}" @if ($pending) data-pending-route="{{ $pending }}" @endif {{ $attributes->merge(['class' => $classes]) }}>@if ($icon)<x-sgdea.icon :name="$icon" :size="16" />@endif{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>@if ($icon)<x-sgdea.icon :name="$icon" :size="16" />@endif{{ $slot }}</button>
@endif
