@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])
@php($classes = 'btn '.match($variant){'outline'=>'btn-outline','ghost'=>'btn-ghost','danger'=>'btn-danger',default=>'btn-primary'})
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
