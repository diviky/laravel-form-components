<div class="form-group">
    <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" />

    <input {!! $attributes->except(['extra-attributes'])->merge(['class' => 'form-range' . ($hasError($name) ? ' is-invalid' : '')]) !!} type="range"
        @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}"
    @else
        value="{{ $value }}" @endif
        name="{{ $name }}"  {{ $extraAttributes ?? '' }} @if ($label && !$attributes->get('id')) id="{{ $id() }}" @endif />

    {!! $help ?? null !!}

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
