<div class="form-group @if ($type === 'hidden') d-none @endif">
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$attributes->has('required')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <div @class([
        'input-group' => isset($prepend) || isset($append),
        'input-icon' => @isset($icon),
    ])>

        @isset($prepend)
            <x-form-input-group-text>
                {!! $prepend !!}
            </x-form-input-group-text>
        @endisset

        @isset($icon)
            <span class="input-icon-addon">
                {!! $icon !!}
            </span>
        @endisset

        <input {!! $attributes->except(['extra-attributes'])->merge([
                'class' => 'form-control',
                'type' => $type,
                'name' => $name,
                'id' => $id(),
                'placeholder' => '&nbsp;',
                'value' => $value ?? ($type === 'color' ? '#000000' : ''),
            ])->class([
                'form-control-color' => $type === 'color',
                'is-invalid' => $hasError($name),
            ]) !!} {{ $extraAttributes ?? '' }}
            @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif />

        @isset($append)
            <x-form-input-group-text>
                {!! $append !!}
            </x-form-input-group-text>
        @endisset
    </div>
    @if ($floating)
        <x-form-label :label="$label":required="$attributes->has('required')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? null !!} </x-help>

@if ($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif

</div>
