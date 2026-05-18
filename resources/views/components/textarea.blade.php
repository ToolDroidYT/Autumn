@props(['label' => null, 'name'])
<div class="field">
    @if($label)<label for="{{ $name }}">{{ $label }}</label>@endif
    <textarea id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'textarea']) }}>{{ old($name, $slot) }}</textarea>
    @error($name)<span class="error">{{ $message }}</span>@enderror
</div>
