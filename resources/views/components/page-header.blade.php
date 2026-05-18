@props(['eyebrow' => null, 'title' => null, 'align' => 'center'])
<div {{ $attributes->merge(['class' => 'section-head '.($align === 'left' ? 'section-head-left' : '')]) }}>
    @if($eyebrow)
        <x-badge>{{ $eyebrow }}</x-badge>
    @endif
    @if($title)
        <h1 class="section-title">{!! $title !!}</h1>
    @endif
    {{ $slot }}
</div>
