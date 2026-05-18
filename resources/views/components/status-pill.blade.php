@props(['status'])
<span {{ $attributes->merge(['class' => 'status '.str_replace(' ', '_', strtolower($status))]) }}>{{ str_replace('_', ' ', $status) }}</span>
