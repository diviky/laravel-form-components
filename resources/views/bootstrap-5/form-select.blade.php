<div class="form-group">
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
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

        <select @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif
            @if ($multiple) multiple @endif {{ $extraAttributes ?? '' }} {!! $attributes->except(['extra-attributes'])->merge([
                    'class' => 'form-select',
                    'id' => $id(),
                    'placeholder' => $placeholder,
                    'value-field' => $valueField,
                    'label-field' => $labelField,
                    'name' => $name,
                    'data-selected' => $selectedKeys,
                ])->class([
                    'is-invalid' => $hasError($name),
                ]) !!}>

            {{ $before ?? '' }}

            @if ($placeholder)
                <option value="" @if ($nothingSelected()) selected="selected" @endif>
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
        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? null !!} </x-help>

@if ($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif
</div>
