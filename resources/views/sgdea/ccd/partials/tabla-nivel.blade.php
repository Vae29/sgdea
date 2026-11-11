{{-- Tabla genérica de un nivel del CCD. Recibe: $nivel, $titulo, $campos (etiqueta => clave), $filas, $nuevo. --}}
@php $tid = 'tbl-ccd-' . $nivel; @endphp
<x-sgdea.card :flush="true">
    <x-sgdea.table :id="$tid" :cols="count($campos) + 2" :placeholder="'Buscar en ' . $titulo . '…'">
        <x-slot:toolbar>
            <select style="width:auto" data-table-status="#{{ $tid }}" aria-label="Filtrar por estado">
                <option value="">Todos los estados</option><option value="1">Activos</option><option value="0">Inactivos</option>
            </select>
            <x-sgdea.button size="sm" icon="plus" data-ccd-new="{{ $nivel }}">Nuevo registro</x-sgdea.button>
        </x-slot:toolbar>
        <x-slot:head>
            <tr>@foreach ($campos as $etiqueta => $clave)<th>{{ $etiqueta }}</th>@endforeach<th>Estado</th><th class="text-right">Acciones</th></tr>
        </x-slot:head>
        @foreach ($filas as $f)
            <tr data-activo="{{ $f['activo'] ? '1' : '0' }}">
                @foreach ($campos as $clave)<td @if ($loop->first && $clave === 'codigo') class="mono" @elseif ($clave === 'oficina' && ($f['sin_oficina'] ?? false)) class="cell-sin" @endif>{{ ($f[$clave] ?? '') !== '' ? $f[$clave] : '—' }}</td>@endforeach
                <td><x-sgdea.badge :status="$f['activo'] ? 'activo' : 'inactivo'" /></td>
                <td class="text-right nowrap">
                    <x-sgdea.button variant="ghost" size="sm" icon="edit" data-ccd-edit="{{ $f['key'] }}">Editar</x-sgdea.button>
                    <x-sgdea.button variant="ghost" size="sm" data-ccd-estado="{{ $f['key'] }}">{{ $f['activo'] ? 'Desactivar' : 'Activar' }}</x-sgdea.button>
                    <x-sgdea.button variant="ghost" size="sm" data-ccd-eliminar="{{ $f['key'] }}">Eliminar</x-sgdea.button>
                </td>
            </tr>
        @endforeach
    </x-sgdea.table>
</x-sgdea.card>
