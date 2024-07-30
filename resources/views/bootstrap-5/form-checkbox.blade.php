<div class="form-check @if (null !== $attributes->get('inline')) form-check-inline @endif">

    @isset($copy)
        <input type="hidden" value="{{ $copy }}" name="{{ $name }}" />
    @endisset

    <input {!! $attributes->except(['extra-attributes'])->merge(['class' => 'form-check-input' . ($hasError($name) ? ' is-invalid' : '')]) !!} type="checkbox" value="{{ $value }}" {{ $extraAttributes ?? '' }}
        @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif
        name="{{ $name }}" @if (!$attributes->get('id')) id="{{ $id() }}" @endif
        @if ($checked) checked="checked" @endif value="{{ $value }}" />

    <x-form-label :label="$label" :required="$attributes->get('required')" :for="$attributes->get('id') ?: $id()" class="form-check-label" />

    {!! $help ?? null !!}

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
