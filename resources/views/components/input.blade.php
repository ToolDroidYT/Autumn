@props(['label' => null, 'name', 'type' => 'text'])
<div class="field">
    @if($label)<label for="{{ $name }}">{{ $label }}</label>@endif
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $attributes->get('value')) }}" {{ $attributes->except('value')->merge(['class' => 'input']) }}>
    @error($name)<span class="error">{{ $message }}</span>@enderror
</div>
