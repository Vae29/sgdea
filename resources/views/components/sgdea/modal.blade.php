@props(['id', 'title', 'size' => 'md'])
<div class="modal modal-{{ $size }}" id="{{ $id }}" role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title" aria-hidden="true">
    <div class="modal-backdrop"></div>
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 id="{{ $id }}-title"><span class="modal-title-text">{{ $title }}</span></h3>
            <button type="button" class="btn-icon" data-modal-close aria-label="Cerrar"><x-sgdea.icon name="x" /></button>
        </div>
        <div class="modal-body">{{ $slot }}</div>
        @isset($footer)<div class="modal-footer">{{ $footer }}</div>@endisset
    </div>
</div>
