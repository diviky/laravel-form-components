<div class="form-group @if ($type === 'hidden') d-none @endif">
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$attributes->get('required')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <div
        class="@if (isset($prepend) || isset($append)) input-group @endif @isset($icon) input-icon @endisset">
        @isset($prepend)
            <div class="input-group-text">
                {!! $prepend !!}
            </div>
        @endisset

        @isset($icon)
            <span class="input-icon-addon">
                {!! $icon !!}
            </span>
        @endisset

        <input {!! $attributes->except(['extra-attributes'])->merge([
            'class' =>
                'form-control' . ($type === 'color' ? ' form-control-color' : '') . ($hasError($name) ? ' is-invalid' : ''),
        ]) !!} {{ $extraAttributes ?? '' }} type="{{ $type }}"
            @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}"
        @else
            value="{{ $value ?? ($type === 'color' ? '#000000' : '') }}" @endif
            name="{{ $name }}" @if ($label && !$attributes->get('id')) id="{{ $id() }}" @endif
            @if ($floating && !$attributes->get('placeholder')) placeholder="&nbsp;" @endif />

        @isset($append)
            <div class="input-group-text">
                {!! $append !!}
            </div>
        @endisset

        @if ($floating)
            <x-form-label :label="$label":required="$attributes->get('required')" :for="$attributes->get('id') ?: $id()" />
        @endif

        @if ($floating)
    </div>
    @endif

    {!! $help ?? null !!}

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>

</div>
