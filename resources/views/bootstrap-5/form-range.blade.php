<div class="form-group">
    <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$id()" />

    <input {!! $attributes->except(['extra-attributes'])->merge(['class' => 'form-range' . ($hasError($inputName()) ? ' is-invalid' : '')]) !!} type="range" {{ $wire() }} value="{{ $value }}"
        name="{{ $inputName() }}" {{ $extraAttributes ?? '' }} id="{{ $id() }}" />

    <x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
    <x-form-errors :name="$inputName()" />
</div>
