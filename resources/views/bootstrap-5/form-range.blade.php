<div class="form-group">
    <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />

    <input {!! $attributes->except(['extra-attributes'])->merge(['class' => 'form-range' . ($hasError($name) ? ' is-invalid' : '')]) !!} type="range" {{ $wire() }} value="{{ $value }}"
        name="{{ $name }}" {{ $extraAttributes ?? '' }} id="{{ $id() }}" />

    <x-help> {!! $help ?? null !!} </x-help>
    <x-form-errors :name="$name" />
</div>
