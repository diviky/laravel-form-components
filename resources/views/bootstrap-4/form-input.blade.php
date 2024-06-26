<div class="@if ($type === 'hidden') d-none @elseif(!isset($prepend) && !isset($append)) form-group @endif">
    <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" />

    <div
        class="@if (isset($prepend) || isset($append)) input-group @endif @isset($icon) input-icon @endisset">
        @isset($prepend)
            <div class="input-group-prepend">
                <div class="input-group-text">
                    {!! $prepend !!}
                </div>
            </div>
        @endisset

        @isset($icon)
            <span class="input-icon-addon">
                {!! $icon !!}
            </span>
        @endisset

        <input {!! $attributes->merge(['class' => 'form-control ' . ($hasError($name) ? 'is-invalid' : '')]) !!} type="{{ $type }}"
            @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}"
            @else
                value="{{ $value }}" @endif
            name="{{ $name }}" @if ($label && !$attributes->get('id')) id="{{ $id() }}" @endif />

        @isset($append)
            <div class="input-group-append">
                <div class="input-group-text">
                    {!! $append !!}
                </div>
            </div>
        @endisset

        @if ($hasErrorAndShow($name))
            <x-form-errors :name="$name" />
        @endif
    </div>

    {!! $help ?? null !!}

</div>
