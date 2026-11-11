@props(['label', 'name', 'type' => 'text', 'required' => false, 'hint' => null, 'options' => [], 'placeholder' => '', 'value' => null, 'error' => null, 'id' => null, 'attr' => [], 'wrapClass' => ''])
@php
    $id = $id ?? 'f-' . $name;
    $err = $error ?? (isset($errors) ? $errors->first($name) : null);
    $val = old($name, $value);
@endphp
<div class="field {{ $err ? 'has-error' : '' }} {{ $wrapClass }}">
    <label for="{{ $id }}">{{ $label }} @if ($required)<span class="req" aria-hidden="true">*</span>@endif</label>
    @if ($type === 'select')
        <select id="{{ $id }}" name="{{ $name }}" @required($required) {{ $attributes->merge($attr) }}>
            <option value="">{{ $placeholder ?: 'Seleccione…' }}</option>
            @foreach ($options as $k => $text)<option value="{{ $k }}" @selected((string) $val === (string) $k)>{{ $text }}</option>@endforeach
        </select>
    @elseif ($type === 'textarea')
        <textarea id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}" @required($required) {{ $attributes->merge($attr) }}>{{ $val }}</textarea>
    @elseif ($type === 'password')
        <div class="input-group">
            <input id="{{ $id }}" type="password" name="{{ $name }}" placeholder="{{ $placeholder }}" @required($required) {{ $attributes->merge($attr) }}>
            <button type="button" class="toggle-pass" data-toggle-password="#{{ $id }}" aria-label="Mostrar contraseña">
                <x-sgdea.icon name="eye" class="icon icon-show" /><x-sgdea.icon name="eye-off" class="icon icon-hide" />
            </button>
        </div>
    @else
        <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" value="{{ $val }}" placeholder="{{ $placeholder }}" @required($required) {{ $attributes->merge($attr) }}>
    @endif
    @if ($hint)<div class="hint">{{ $hint }}</div>@endif
    @if ($err)<div class="field-error" data-server role="alert"><x-sgdea.icon name="alert-circle" :size="14" />{{ $err }}</div>@endif
</div>
