{{--
  Módulo 7 · Usuarios y control de acceso (SOLO VISUAL; sin autenticación ni autorización reales).
  Variables del futuro controlador: $usuarios (con roles y oficina), $roles, $unidades, $resumenNiveles, $esDemo.
  Tablas relacionadas: usuarios, roles, rol_usuario, oficinas_productoras.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Usuarios y control de acceso')
@section('subtitle', 'Usuarios, roles y niveles de confidencialidad documental')
@section('module', 'usuarios')

@php
    $demo = require resource_path('sgdea/demo/usuarios.php');
    $usuarios = $usuarios ?? $demo['usuarios'];
    $roles = $roles ?? $demo['roles'];
    $esDemo = $esDemo ?? true;
    $demoCcd = require resource_path('sgdea/demo/ccd.php');
    $unidades = $unidades ?? $demoCcd['unidades'];
    $ccd = (require resource_path('sgdea/presenters/ccd.php'))($demoCcd['fondo'], $unidades);
    $unidadOpciones = collect($unidades)->mapWithKeys(fn ($u) => ['u:' . $u['codigo'] => $u['codigo'] . ' · ' . $u['nombre']])->all();
    $rolOpciones = collect($roles)->pluck('nombre')->all();
    $conteoRol = collect($usuarios)->flatMap(fn ($u) => $u['roles'])->countBy()->all();
    $carpetas = require resource_path('sgdea/demo/carpetas.php');
    $documentos = require resource_path('sgdea/demo/documentos.php');
    $resumenNiveles = $resumenNiveles ?? collect(['publica', 'clasificada', 'reservada'])->mapWithKeys(fn ($n) => [$n => [
        'carpetas' => collect($carpetas)->where('nivel_acceso', $n)->count(), 'documentos' => collect($documentos)->where('nivel_acceso', $n)->count()]])->all();
    $json = json_encode($usuarios, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

@section('content')
    <x-sgdea.page-header>
        <x-slot:actions><x-sgdea.button icon="plus" data-usuario-nuevo>Nuevo usuario</x-sgdea.button></x-slot:actions>
    </x-sgdea.page-header>
    @if ($esDemo)<x-sgdea.alert type="warning" title="Datos de demostración">Usuarios ficticios. Esta pantalla no autentica ni autoriza: solo representa la administración de usuarios, roles y niveles de acceso.</x-sgdea.alert>@endif

    <div data-tabs>
        <div class="tabs" role="tablist">
            <button type="button" class="tab-btn is-active" data-tab-target="#usr-tab-usuarios">Usuarios ({{ count($usuarios) }})</button>
            <button type="button" class="tab-btn" data-tab-target="#usr-tab-roles">Roles ({{ count($roles) }})</button>
            <button type="button" class="tab-btn" data-tab-target="#usr-tab-niveles">Niveles de acceso documental</button>
        </div>

        <div class="tab-panel is-active" id="usr-tab-usuarios">
            <x-sgdea.card :flush="true">
                <x-sgdea.table id="tbl-usuarios" :cols="6" placeholder="Buscar por nombre, correo o rol…">
                    <x-slot:toolbar>
                        <select style="width:auto" id="usr-f-estado" aria-label="Filtrar por estado"><option value="">Todas las cuentas</option><option value="1">Activas</option><option value="0">Inactivas</option></select>
                        <select style="width:auto" id="usr-f-rol" aria-label="Filtrar por rol"><option value="">Todos los roles</option>@foreach ($rolOpciones as $r)<option>{{ $r }}</option>@endforeach</select>
                    </x-slot:toolbar>
                    <x-slot:head><tr><th>Nombre</th><th>Correo</th><th>Oficina productora</th><th>Roles</th><th>Estado</th><th class="text-right">Acciones</th></tr></x-slot:head>
                    @foreach ($usuarios as $i => $u)
                        <tr data-activo="{{ $u['activo'] ? '1' : '0' }}" data-roles="{{ implode('|', $u['roles']) }}">
                            <td><strong>{{ $u['nombre_completo'] }}</strong></td><td class="small">{{ $u['correo'] }}</td><td class="small">{{ $u['oficina'] ?? 'Sin oficina asignada' }}</td>
                            <td>@foreach ($u['roles'] as $r)<x-sgdea.badge tone="info" :label="$r" :dot="false" /> @endforeach</td>
                            <td><x-sgdea.badge :status="$u['activo'] ? 'activo' : 'inactivo'" /></td>
                            <td class="text-right nowrap">
                                <x-sgdea.button variant="ghost" size="sm" icon="eye" data-usuario-ver="{{ $i }}">Ver</x-sgdea.button>
                                <x-sgdea.button variant="ghost" size="sm" icon="edit" data-usuario-editar="{{ $i }}">Editar</x-sgdea.button>
                                <x-sgdea.button variant="ghost" size="sm" data-usuario-estado="{{ $i }}">{{ $u['activo'] ? 'Desactivar' : 'Activar' }}</x-sgdea.button>
                            </td>
                        </tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>

        <div class="tab-panel" id="usr-tab-roles">
            <x-sgdea.alert type="info">La descripción de cada rol es orientativa (tomada de las historias de usuario). Los permisos exactos por rol están por definir con la empresa.</x-sgdea.alert>
            <div class="grid grid-3">
                @foreach ($roles as $r)
                    <x-sgdea.card :title="$r['nombre']">
                        <x-slot:actions><x-sgdea.badge tone="neutral" :label="($conteoRol[$r['nombre']] ?? 0) . ' usuario(s)'" :dot="false" /></x-slot:actions>
                        <p class="small" style="margin:0">{{ $r['descripcion'] }}</p>
                    </x-sgdea.card>
                @endforeach
            </div>

            <x-sgdea.card title="Permisos por rol" class="mt-2" :flush="true">
                <x-slot:actions><x-sgdea.badge tone="warning" label="Sin asignar · pendiente de definición" :dot="false" /></x-slot:actions>
                <p class="small muted" style="margin:.8rem 1rem">Esquema RBAC (HU-GDO-07). Los permisos son una propuesta por módulo; la empresa debe definir qué rol tiene cada uno. Las casillas no guardan nada en esta demostración.</p>
                <x-sgdea.table id="tbl-permisos" :searchable="false" :cols="6">
                    <x-slot:head><tr><th>Permiso</th>@foreach ($rolOpciones as $r)<th class="text-right">{{ $r }}</th>@endforeach</tr></x-slot:head>
                    @foreach (['dashboard.ver' => 'Ver el panel principal', 'ccd.ver' => 'Consultar el CCD', 'ccd.administrar' => 'Administrar el CCD', 'trd.ver' => 'Consultar la TRD', 'trd.administrar' => 'Parametrizar la TRD',
                        'radicacion.ver' => 'Consultar radicaciones', 'radicacion.crear' => 'Radicar comunicaciones', 'documento.ver' => 'Consultar documentos', 'documento.crear' => 'Registrar documentos', 'documento.descargar' => 'Descargar documentos',
                        'carpeta.ver' => 'Consultar carpetas', 'carpeta.crear' => 'Abrir carpetas', 'carpeta.incorporar' => 'Incorporar documentos', 'carpeta.cerrar' => 'Cerrar carpetas',
                        'fuid.ver' => 'Consultar el FUID', 'fuid.exportar' => 'Exportar el FUID', 'usuarios.administrar' => 'Administrar usuarios y roles', 'auditoria.ver' => 'Consultar la auditoría',
                        'transferencia.ver' => 'Consultar transferencias', 'transferencia.crear' => 'Crear transferencias', 'transferencia.aprobar' => 'Aprobar transferencias',
                        'disposicion.solicitar' => 'Solicitar disposición final', 'disposicion.aprobar' => 'Aprobar disposición final'] as $perm => $texto)
                        <tr><td><span class="mono small">{{ $perm }}</span><div class="small muted">{{ $texto }}</div></td>
                            @foreach ($rolOpciones as $r)<td class="text-right"><input type="checkbox" class="perm-chk" data-rol="{{ $r }}" data-perm="{{ $perm }}" aria-label="{{ $perm }} para {{ $r }}" style="width:auto"></td>@endforeach</tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>

        <div class="tab-panel" id="usr-tab-niveles">
            <div class="grid grid-3 mb-2">
                @foreach ([['publica', 'Pública', 'Información de acceso abierto.'], ['clasificada', 'Clasificada', 'Acceso restringido: solo con el rol o la autorización de la dependencia correspondiente.'], ['reservada', 'Reservada', 'Acceso restringido: solo con el rol o la autorización de la dependencia correspondiente.']] as [$k, $nombre, $texto])
                    <x-sgdea.card>
                        <x-sgdea.badge :status="$k" />
                        <h3 style="margin:.6rem 0 .3rem;font-size:1rem">{{ $nombre }}</h3>
                        <p class="small muted" style="margin:0 0 .6rem">{{ $texto }}</p>
                        <dl class="dl" style="grid-template-columns:100px 1fr"><dt>Carpetas</dt><dd>{{ $resumenNiveles[$k]['carpetas'] }}</dd><dt>Documentos</dt><dd>{{ $resumenNiveles[$k]['documentos'] }}</dd></dl>
                    </x-sgdea.card>
                @endforeach
            </div>
            <x-sgdea.card title="Qué ve un usuario sin autorización">
                <p class="small muted" style="margin-top:0">Cuando el acceso es restringido, el sistema deniega la consulta y no muestra enlaces a los archivos. Vista previa del mensaje:</p>
                <x-sgdea.button variant="outline" icon="lock" data-modal-open="modal-acceso-denegado">Ver mensaje de acceso denegado</x-sgdea.button>
                <p class="small muted mt-1" style="margin-bottom:0">El nivel de acceso se guarda hoy en carpetas y documentos. Configurarlo por serie o subserie (HU-GDO-07) requiere definir dónde se almacena.</p>
            </x-sgdea.card>

            <x-sgdea.card title="Nivel de acceso por serie y subserie (TCA)" class="mt-2" :flush="true">
                <p class="small muted" style="margin:.8rem 1rem">El nivel se configura en la serie o subserie y se hereda al documento (HU-GDO-07). Hoy el modelo guarda el nivel en carpetas y documentos; dónde se almacena a nivel de serie o subserie queda pendiente de confirmar. «Sin definir» es el valor inicial: no se asigna ninguno por suposición.</p>
                <x-sgdea.table id="tbl-tca" :cols="4" placeholder="Buscar serie, subserie u oficina…">
                    <x-slot:head><tr><th>Serie / subserie</th><th>Tipo</th><th>Dependencia</th><th>Nivel de acceso</th></tr></x-slot:head>
                    @foreach (collect($ccd['tablas']['series'])->map(fn ($r) => ['key' => $r['key'], 'tipo' => 'Serie', 'texto' => $r['codigo'] . ' · ' . $r['nombre'], 'dep' => $r['oficina'] . ' (' . $r['unidad'] . ')'])
                        ->merge(collect($ccd['tablas']['subseries'])->map(fn ($r) => ['key' => $r['key'], 'tipo' => 'Subserie', 'texto' => $r['codigo'] . ' · ' . $r['nombre'] . ' — ' . $r['serie'], 'dep' => $r['oficina']])) as $r)
                        <tr><td>{{ $r['texto'] }}</td><td class="small">{{ $r['tipo'] }}</td><td class="small">{{ $r['dep'] }}</td>
                            <td><select class="tca-sel" style="width:auto" data-key="{{ $r['key'] }}" aria-label="Nivel de acceso"><option value="">Sin definir</option><option value="publica">Pública</option><option value="clasificada">Clasificada</option><option value="reservada">Reservada</option></select></td></tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>
    </div>
    <script type="application/json" id="usr-data">{!! $json !!}</script>
    @include('sgdea.partials.json-options', ['opciones' => ['oficinas' => $ccd['opciones']['oficinas']]])
@endsection

@push('modals')
    <x-sgdea.modal id="modal-usuario-detalle" title="Información del usuario" size="md">
        <dl class="dl" style="grid-template-columns:130px 1fr">
            <dt>Nombre completo</dt><dd data-u="nombre_completo"></dd><dt>Correo</dt><dd data-u="correo"></dd><dt>Oficina productora</dt><dd data-u="oficina"></dd>
            <dt>Roles</dt><dd data-u="roles"></dd><dt>Estado de la cuenta</dt><dd data-u="estado"></dd><dt>Creado el</dt><dd data-u="fecha_creacion"></dd>
        </dl>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>

    <x-sgdea.modal id="modal-usuario-form" title="Nuevo usuario" size="md">
        <form id="form-usuario" method="POST" action="#" data-demo-form data-demo-message="Demostración: el usuario no fue guardado. La gestión de usuarios y contraseñas se hará en el backend." novalidate>
            @csrf
            <x-sgdea.field label="Nombre completo" name="nombre_completo" :required="true" />
            <x-sgdea.field label="Correo electrónico" name="correo" type="email" :required="true" />
            <div class="form-grid">
                <x-sgdea.field label="Unidad administrativa" name="filtro_unidad_id" type="select" id="usr-unidad" placeholder="Sin oficina" :options="$unidadOpciones" />
                <x-sgdea.field label="Oficina productora" name="oficina_productora_id" type="select" id="usr-oficina" :options="[]" :attr="['data-parent' => 'usr-unidad', 'data-options-from' => 'opt-oficinas', 'data-empty-text' => 'No tiene oficinas productoras asociadas']" />
            </div>
            <fieldset style="border:0;padding:0;margin:0 0 1rem"><legend class="small" style="font-weight:600;margin-bottom:.3rem">Roles</legend>
                @foreach ($rolOpciones as $r)<label class="check" style="margin-bottom:.3rem"><input type="checkbox" name="roles[]" value="{{ $r }}"> {{ $r }}</label>@endforeach
            </fieldset>
            <label class="check"><input type="checkbox" name="activo" value="1" checked> Cuenta activa</label>
            <p class="small muted" style="margin-bottom:0">La contraseña inicial y su recuperación las gestionará el backend.</p>
        </form>
        <x-slot:footer>
            <x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button>
            <x-sgdea.button type="submit" form="form-usuario" icon="check">Guardar</x-sgdea.button>
        </x-slot:footer>
    </x-sgdea.modal>

    <x-sgdea.modal id="modal-usuario-estado" title="Confirmar cambio de estado" size="sm">
        <p id="usr-estado-texto"></p>
        <x-sgdea.alert type="warning">Demostración: el cambio no se guardará hasta conectar el backend.</x-sgdea.alert>
        <x-slot:footer>
            <x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button>
            <x-sgdea.button data-demo-toast="Demostración: el estado de la cuenta no se modificó." data-toast-type="warning">Confirmar</x-sgdea.button>
        </x-slot:footer>
    </x-sgdea.modal>

    <x-sgdea.modal id="modal-acceso-denegado" title="Acceso denegado" size="sm">
        <x-sgdea.alert type="error" title="No tiene autorización para consultar este documento">
            La información está calificada como Clasificada o Reservada. Para acceder necesita el rol o la autorización de la dependencia responsable.
        </x-sgdea.alert>
        <p class="small muted" style="margin-bottom:0">Fundamento normativo: Ley 1712 de 2014 (arts. 18 y 19) y Ley 1581 de 2012. El texto definitivo de reserva legal lo define la empresa.</p>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>
@endpush
@push('scripts')<script src="{{ asset('sgdea/js/usuarios.js') }}"></script>@endpush
