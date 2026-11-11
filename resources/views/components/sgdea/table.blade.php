@props(['id', 'searchable' => true, 'placeholder' => 'Buscar en la tabla…', 'emptyText' => 'No se encontraron registros.', 'cols' => 1])
<div {{ $attributes->merge(['class' => 'table-block']) }}>
    @if ($searchable || isset($toolbar))
        <div class="table-toolbar">
            @if ($searchable)
                <div class="search-box"><x-sgdea.icon name="search" :size="16" />
                    <input type="search" data-table-search="#{{ $id }}" placeholder="{{ $placeholder }}" aria-label="{{ $placeholder }}"></div>
            @endif
            @isset($toolbar)<div class="flex flex-wrap">{{ $toolbar }}</div>@endisset
        </div>
    @endif
    <div class="table-wrap">
        <table class="table" id="{{ $id }}">
            <thead>{{ $head }}</thead>
            <tbody>
                {{ $slot }}
                <tr class="table-empty" hidden><td colspan="{{ $cols }}">{{ $emptyText }}</td></tr>
            </tbody>
        </table>
    </div>
</div>
