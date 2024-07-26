<div class="form-check @if(null !== $attributes->get('switch')) form-switch @endif @if(null !== $attributes->get('inline')) form-check-inline @endif">

    @isset ($copy)
        <input type="hidden" value="{{ $copy }}" name="{{ $name }}" />
    @endisset

    <input
        {!! $attributes->except(['extra-attributes'])->merge(['class' => 'form-check-input' . ($hasError($name) ? ' is-invalid' : '')]) !!}

        type="checkbox"

        value="{{ $value }}"

        {{ $extraAttributes ?? '' }}

        @if($isWired())
            wire:model{!! $wireModifier() !!}="{{ $name }}"
        @endif

        name="{{ $name }}"

        @if($label && !$attributes->get('id'))
            id="{{ $id() }}"
        @endif

        @if($checked)
            checked="checked"
        @endif
    />

    <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" class="form-check-label" />

    {!! $help ?? null !!}

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
