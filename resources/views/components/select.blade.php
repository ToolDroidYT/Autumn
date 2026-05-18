@props(['label' => null, 'name', 'options' => [], 'selected' => null])
<div class="field">
    @if($label)<label for="{{ $name }}">{{ $label }}</label>@endif
    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'select']) }}>
        @foreach($options as $value => $optionLabel)
            <option value="{{ $value }}" @selected(old($name, $selected) == $value)>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)<span class="error">{{ $message }}</span>@enderror
</div>
