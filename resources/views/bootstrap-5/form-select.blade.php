@if ($floating)
    <div class="form-floating">
@endif

@if (!$floating)
    <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" />
@endif

<select @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif
    name="{{ $name }}" @if ($multiple) multiple @endif
    @if ($placeholder) placeholder="{{ $placeholder }}" @endif
    @if ($label && !$attributes->get('id')) id="{{ $id() }}" @endif {!! $attributes->merge(['class' => 'form-select' . ($hasError($name) ? ' is-invalid' : '')]) !!}>

    @if ($placeholder)
        <option value="" disabled @if ($nothingSelected()) selected="selected" @endif>
            {{ $placeholder }}
        </option>
    @endif

    {!! $slot !!}

    @foreach($options as $key => $option)
        @if ($optionIsOptGroup($option))
            <optgroup label="{{ $optionLabel($option) }}">
                @foreach ($optionChildren($option) as $child)
                    <option value="{{ $optionValue($child) }}" @selected($isSelected($optionValue($child))) @disabled($optionIsDisabled($child))>
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

    {{ $append ?? '' }}
</select>

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
