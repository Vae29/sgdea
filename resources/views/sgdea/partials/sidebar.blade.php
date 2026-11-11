@php
    $menu = require resource_path('sgdea/navigation.php');
    $activeModule = $activeModule ?? '';
@endphp
<aside class="sidebar" id="sidebar" aria-label="Menú principal">
    <div class="sidebar-brand">
        <div class="logo-box"><img src="{{ asset('sgdea/img/logo-evc.png') }}" alt="EVC E.S.P."></div>
        <div><strong>SGDEA</strong><span>EVC E.S.P.</span></div>
    </div>
    <nav class="sidebar-nav">
        @foreach ($menu as $group)
            <p class="sidebar-group">{{ $group['label'] }}</p>
            @foreach ($group['items'] as $item)
                @php $href = \Illuminate\Support\Facades\Route::has($item['route']) ? route($item['route']) : null; @endphp
                <a href="{{ $href ?? '#' }}"
                   class="sidebar-link {{ $activeModule === $item['key'] ? 'is-active' : '' }} {{ $href ? '' : 'is-pending' }}"
                   @unless ($href) data-pending-route="{{ $item['route'] }}" @endunless
                   @if ($activeModule === $item['key']) aria-current="page" @endif>
                    <x-sgdea.icon :name="$item['icon']" />
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        @endforeach
    </nav>
    <div class="sidebar-foot">Frontend de demostración · Etapa 1</div>
</aside>
