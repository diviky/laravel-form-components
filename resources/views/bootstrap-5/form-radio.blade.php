<div class="form-check @if (null !== $attributes->get('inline')) form-check-inline @endif">
    <input {!! $attributes->except(['extra-attributes'])->merge(['class' => 'form-check-input' . ($hasError($name) ? ' is-invalid' : '')]) !!} type="radio" value="{{ $value }}" {{ $extraAttributes ?? '' }}
        @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif
        name="{{ $name }}" @if ($label && !$attributes->get('id')) id="{{ $id() }}" @endif
        @checked($checked) />

    <x-form-label :label="$label" :required="$attributes->has('required')" :for="$attributes->get('id') ?: $id()" class="form-check-label" />

    <x-help> {!! $help ?? null !!} </x-help>

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
