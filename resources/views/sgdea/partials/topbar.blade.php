@php
    $shell = require resource_path('sgdea/demo/shell.php');
    $usuarioActual = $usuarioActual ?? $shell['usuario'];
    $notificaciones = $notificaciones ?? $shell['notificaciones'];
    $iniciales = collect(explode(' ', $usuarioActual['nombre_completo']))->filter()->take(2)->map(fn ($p) => mb_substr($p, 0, 1))->implode('');
    $toneIcon = ['warning' => 'alert-triangle', 'danger' => 'alert-circle', 'info' => 'info', 'success' => 'check-circle'];
@endphp
<header class="topbar">
    <button type="button" class="btn-icon" data-sidebar-toggle aria-label="Abrir o cerrar el menú lateral"><x-sgdea.icon name="menu" :size="22" /></button>
    <div class="topbar-title">
        <h1>@yield('title', 'SGDEA')</h1>
        @hasSection('subtitle')<p>@yield('subtitle')</p>@endif
    </div>
    <div class="topbar-actions">
        <div class="dropdown" data-dropdown>
            <button type="button" class="btn-icon" data-dropdown-trigger aria-label="Notificaciones">
                <x-sgdea.icon name="bell" :size="20" />
                @if (count($notificaciones))<span class="dot-count">{{ count($notificaciones) }}</span>@endif
            </button>
            <div class="dropdown-menu">
                <div class="dropdown-head">Notificaciones <x-sgdea.badge status="demo" :dot="false" /></div>
                @forelse ($notificaciones as $n)
                    <div class="dropdown-item">
                        <x-sgdea.icon :name="$toneIcon[$n['tono']] ?? 'info'" :size="16" />
                        <div>{{ $n['texto'] }}<div class="t">{{ $n['tiempo'] }}</div></div>
                    </div>
                @empty
                    <div class="dropdown-item muted">Sin notificaciones.</div>
                @endforelse
            </div>
        </div>
        <div class="dropdown" data-dropdown>
            <button type="button" class="user-btn" data-dropdown-trigger aria-label="Menú de usuario">
                <span class="avatar">{{ $iniciales }}</span>
                <span class="user-meta"><strong>{{ $usuarioActual['nombre_completo'] }}</strong><span>{{ $usuarioActual['rol'] }}</span></span>
                <x-sgdea.icon name="chevron-down" :size="14" />
            </button>
            <div class="dropdown-menu" style="min-width:230px">
                <div class="dropdown-head">{{ $usuarioActual['nombre_completo'] }}<div class="small muted" style="font-weight:400">{{ $usuarioActual['oficina'] }}</div></div>
                <a class="dropdown-item" href="#" data-demo-toast="Demostración: el perfil de usuario se conectará con el backend." style="text-decoration:none;color:inherit"><x-sgdea.icon name="user" :size="16" />Mi perfil</a>
                <a class="dropdown-item" href="#" data-demo-toast="Demostración: el cierre de sesión se conectará con el sistema de autenticación." style="text-decoration:none;color:inherit"><x-sgdea.icon name="log-out" :size="16" />Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>
