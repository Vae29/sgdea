@props(['title' => null, 'flush' => false])
<section {{ $attributes->merge(['class' => 'card']) }}>
    @if ($title || isset($actions))
        <header class="card-header">
            <h3>{{ $title }}</h3>
            @isset($actions)<div class="flex">{{ $actions }}</div>@endisset
        </header>
    @endif
    <div class="card-body {{ $flush ? 'flush' : '' }}">{{ $slot }}</div>
</section>
