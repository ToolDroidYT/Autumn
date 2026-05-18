@props(['tone' => 'orange'])
<span {{ $attributes->merge(['class' => 'badge '.($tone === 'red' ? 'badge-red' : ($tone === 'green' ? 'badge-green' : ($tone === 'blue' ? 'badge-blue' : ($tone === 'purple' ? 'badge-purple' : ''))))]) }}>{{ $slot }}</span>
