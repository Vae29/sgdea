{{--
  Formularios visuales de creación/edición del CCD. Cada nivel solo permite elegir un padre válido:
  Fondo → Unidad administrativa → Oficina productora → Serie → Subserie → Tipo documental.
  La SERIE se vincula siempre a una OFICINA PRODUCTORA (nunca directamente a una unidad).
  Recibe: $fondoOpciones, $soportes.
--}}
@php
    $etq = ['fondo' => 'Fondo documental', 'unidad' => 'Unidad administrativa', 'oficina' => 'Oficina productora', 'serie' => 'Serie documental', 'subserie' => 'Subserie documental'];
    $fuente = ['unidad' => 'opt-unidades', 'oficina' => 'opt-oficinas', 'serie' => 'opt-series', 'subserie' => 'opt-subseries'];
    $vacio = ['unidad' => 'No tiene unidades administrativas', 'oficina' => 'No tiene oficinas productoras asociadas', 'serie' => 'No tiene series documentales asociadas', 'subserie' => 'Esta serie no tiene subseries'];
    $alerta = [
        'oficina' => 'La unidad seleccionada no tiene oficinas productoras asociadas. No es posible crear series en ella hasta registrar una oficina productora.',
        'serie' => 'La oficina seleccionada no tiene series documentales asociadas.',
    ];
    $columnaPadre = ['unidad' => 'fondo_id', 'oficina' => 'unidad_administrativa_id', 'serie' => 'oficina_productora_id', 'subserie' => 'serie_id', 'tipo' => 'serie_id'];
    $niveles = [
        'fondo' => ['t' => 'fondo documental', 'cadena' => [], 'padre' => null, 'nota' => null],
        'unidad' => ['t' => 'unidad administrativa', 'cadena' => ['fondo'], 'padre' => 'fondo', 'nota' => null],
        'oficina' => ['t' => 'oficina productora', 'cadena' => ['fondo', 'unidad'], 'padre' => 'unidad', 'nota' => 'Una oficina productora pertenece a una unidad administrativa.'],
        'serie' => ['t' => 'serie documental', 'cadena' => ['fondo', 'unidad', 'oficina'], 'padre' => 'oficina', 'nota' => 'La serie se vincula siempre a una oficina productora. No puede asociarse directamente a una unidad administrativa.'],
        'subserie' => ['t' => 'subserie documental', 'cadena' => ['fondo', 'unidad', 'oficina', 'serie'], 'padre' => 'serie', 'nota' => null],
        'tipo' => ['t' => 'tipo documental', 'cadena' => ['fondo', 'unidad', 'oficina', 'serie', 'subserie'], 'padre' => 'serie', 'nota' => 'El tipo documental se vincula a una serie y, cuando corresponda, a una de sus subseries.'],
    ];
@endphp

@foreach ($niveles as $nivel => $cfg)
    <x-sgdea.modal :id="'modal-ccd-' . $nivel" :title="'Nuevo/a ' . $cfg['t']" :size="$nivel === 'tipo' ? 'lg' : 'md'">
        <form id="form-ccd-{{ $nivel }}" method="POST" action="#" data-demo-form novalidate>
            @csrf
            @if ($cfg['nota'])<div class="rule-note">{{ $cfg['nota'] }}</div>@endif

            @foreach ($cfg['cadena'] as $i => $a)
                @php
                    $esPadre = $a === $cfg['padre'];
                    $nombre = $esPadre ? $columnaPadre[$nivel] : 'filtro_' . $a . '_id';
                    $id = $nivel . '-' . $a;
                    $attrs = $i === 0 ? [] : ['data-parent' => $nivel . '-' . $cfg['cadena'][$i - 1], 'data-options-from' => $fuente[$a], 'data-empty-text' => $vacio[$a]];
                    if ($esPadre && isset($alerta[$a])) { $attrs['data-guard'] = '1'; }
                    if ($nivel === 'tipo' && $a === 'serie') { $attrs['data-guard'] = '1'; }
                    if ($nivel === 'subserie' && $a === 'serie') { $attrs['data-guard'] = '1'; }
                    $opcionalTipo = $nivel === 'tipo' && $a === 'subserie';
                @endphp
                <x-sgdea.field :label="$etq[$a] . ($opcionalTipo ? ' (si corresponde)' : '')" :name="$opcionalTipo ? 'subserie_id' : $nombre" type="select" :id="$id"
                    :required="!$opcionalTipo" :options="$i === 0 ? $fondoOpciones : []" :hint="$esPadre ? 'Nivel al que se vincula el registro.' : null" :attr="$attrs" />
                @if ($esPadre && isset($alerta[$a]))
                    <x-sgdea.alert type="info" data-guard-alert="{{ $id }}" hidden>{{ $alerta[$a] }}</x-sgdea.alert>
                @endif
            @endforeach

            @if ($nivel === 'serie')
                <x-sgdea.alert type="warning" id="serie-nota-sin-oficina" hidden title="Oficina productora no especificada en el CCD">
                    Esta serie figura en el CCD oficial sin oficina productora. El modelo de datos actual exige una oficina para guardarla; la relación no se inventa y queda pendiente de confirmar.
                </x-sgdea.alert>
            @endif
            <div class="form-grid">
                @if ($nivel !== 'tipo')
                    <x-sgdea.field label="Código" name="codigo" :required="true" :hint="$nivel === 'fondo' ? 'El CCD oficial no indica un código para el fondo; lo define la empresa.' : null" />
                @endif
                <x-sgdea.field label="Nombre" name="nombre" :required="true" :wrap-class="$nivel === 'tipo' ? 'span-2' : ''" />
                @if ($nivel === 'tipo')
                    <x-sgdea.field label="Tipo de soporte" name="tipo_soporte_id" type="select" :required="true" :options="['Físico' => 'Físico', 'Electrónico' => 'Electrónico (incluye audiovisual y fotográfico)', 'Híbrido' => 'Híbrido']" hint="Discriminación de soporte según HU-GDO-02. El texto original del CCD se conserva en la tabla." />
                    <x-sgdea.field label="Especificación de formato" name="especificacion_formato" hint="Opcional. Ejemplo: PDF, XLSX." />
                @endif
            </div>
            <label class="check"><input type="checkbox" name="activo" value="1" checked> Registro activo</label>
        </form>
        <x-slot:footer>
            <x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button>
            <x-sgdea.button type="submit" form="form-ccd-{{ $nivel }}" icon="check">Guardar</x-sgdea.button>
        </x-slot:footer>
    </x-sgdea.modal>
@endforeach

<x-sgdea.modal id="modal-ccd-estado" title="Confirmar cambio de estado" size="sm">
    <p id="ccd-estado-texto"></p>
    <x-sgdea.alert type="warning">Demostración: el cambio no se guardará hasta conectar el backend.</x-sgdea.alert>
    <x-slot:footer>
        <x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button>
        <x-sgdea.button id="ccd-estado-ok">Confirmar</x-sgdea.button>
    </x-slot:footer>
</x-sgdea.modal>

<x-sgdea.modal id="modal-ccd-eliminar" title="Eliminar registro del CCD" size="sm">
    <div id="ccd-eliminar-cuerpo"></div>
    <x-slot:footer>
        <x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button>
        <x-sgdea.button variant="danger" id="ccd-eliminar-ok" icon="alert-circle" data-demo-toast="Demostración: el registro no fue eliminado. La regla de integridad referencial la aplicará el backend." data-toast-type="warning">Eliminar</x-sgdea.button>
    </x-slot:footer>
</x-sgdea.modal>
