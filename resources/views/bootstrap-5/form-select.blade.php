<div class="form-group">
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" />
    @endif

    @isset($prepend)
        <div class="input-group-text">
            {!! $prepend !!}
        </div>
    @endisset

    <select @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif
        name="{{ $name }}" @if ($multiple) multiple @endif
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif {{ $extraAttributes ?? '' }}
        @if ($label && !$attributes->get('id')) id="{{ $id() }}" @endif {!! $attributes->except(['extra-attributes'])->merge(['class' => 'form-select' . ($hasError($name) ? ' is-invalid' : '')]) !!}
        value-field="{{ $valueField }}" label-field="{{ $labelField }}">

        {{ $before ?? '' }}

        @if ($placeholder)
            <option value="" disabled @if ($nothingSelected()) selected="selected" @endif>
                {{ $placeholder }}
            </option>
        @endif

        {!! $slot !!}

        @foreach ($options as $key => $option)
            @if ($optionIsOptGroup($option))
                <optgroup label="{{ $optionLabel($option) }}">
                    @foreach ($optionChildren($option) as $child)
                        <option value="{{ $optionValue($child) }}" @selected($isSelected($optionValue($child)))
                            @disabled($optionIsDisabled($child))>
                            {{ $optionLabel($child) }}
                        </option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{ $optionValue($option) }}" @selected($isSelected($optionValue($option))) @disabled($optionIsDisabled($option))>
                    {{ $optionLabel($option) }}
                </option>
            @endif
        @endforeach

        {{ $after ?? '' }}
    </select>

    @isset($append)
        <div class="input-group-text">
            {!! $append !!}
        </div>
    @endisset

    @if ($floating)
        <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" />
    @endif

    @if ($floating)
</div>
@endif

{!! $help ?? null !!}

@if ($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif
</div>
