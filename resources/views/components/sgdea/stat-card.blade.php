@props(['label', 'value', 'icon' => 'file', 'tone' => 'primary', 'note' => null])
<div {{ $attributes->merge(['class' => 'card stat-card']) }}>
    <div class="stat-icon tone-{{ $tone }}"><x-sgdea.icon :name="$icon" :size="22" /></div>
    <div>
        <div class="stat-value">{{ is_numeric($value) ? number_format($value, 0, ',', '.') : $value }}</div>
        <div class="stat-label">{{ $label }}</div>
        @if ($note)<div class="stat-note">{{ $note }}</div>@endif
    </div>
</div>
