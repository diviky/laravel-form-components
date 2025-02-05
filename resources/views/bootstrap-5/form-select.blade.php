<div @class([
    'form-group' => !$inline,
])>
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <div @class([
        'input-group' => isset($prepend) || isset($append),
        'input-group-flat' => $attributes->has('flat'),
        'input-group-sm' => (isset($prepend) || isset($append)) && $size == 'sm',
        'input-group-lg' => (isset($prepend) || isset($append)) && $size == 'lg',
        'input-icon' => @isset($icon),
    ])>

        @isset($prepend)
            <x-form-input-group-text>
                {!! $prepend !!}
            </x-form-input-group-text>
        @endisset

        @isset($icon)
            <span class="input-icon-addon">
                <x-icon :name="$icon" />
            </span>
        @endisset

        <select {{ $wire() }} @if ($multiple) multiple @endif {{ $extraAttributes ?? '' }}
            {!! $attributes->except(['extra-attributes'])->merge([
                    'id' => $id(),
                    'placeholder' => $placeholder,
                    'value-field' => $valueField,
                    'label-field' => $labelField,
                    'name' => $name,
                    'data-selected' => $values,
                ])->class([
                    'form-select' => true,
                    'form-select-sm' => $size == 'sm',
                    'form-select-lg' => $size == 'lg',
                    'is-invalid' => $hasError($name),
                ]) !!}>

            {{ $before ?? '' }}

            @if ($placeholder)
                <option value="" @if ($nothingSelected()) selected="selected" @endif>
                    {{ $placeholder }}
                </option>
            @endif

            {!! $slot !!}

            @foreach ($options as $option)
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
                    <option value="{{ $optionValue($option) }}" @selected($isSelected($optionValue($option)))
                        @disabled($optionIsDisabled($option))>
                        {{ $optionLabel($option) }}
                    </option>
                @endif
            @endforeach

            {{ $after ?? '' }}
        </select>

        @isset($append)
            <x-form-input-group-text>
                {!! $append !!}
            </x-form-input-group-text>
        @endisset
    </div>
    @if ($floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? null !!} </x-help>

@if ($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif
</div>
