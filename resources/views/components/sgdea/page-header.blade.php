@props(['title' => null, 'subtitle' => null])
<div class="page-header">
    <div>@if ($title)<h2>{{ $title }}</h2>@endif @if ($subtitle)<p>{{ $subtitle }}</p>@endif</div>
    @isset($actions)<div class="flex flex-wrap">{{ $actions }}</div>@endisset
</div>
