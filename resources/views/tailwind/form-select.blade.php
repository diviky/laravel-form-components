<div class="mt-4">
    <label class="block">
        <x-form-label :label="$label" />

        <select
            @if($isWired())
                wire:model{!! $wireModifier() !!}="{{ $name }}"
            @endif

            name="{{ $name }}"

            @if($multiple)
                multiple
            @endif

            @if($placeholder)
                placeholder="{{ $placeholder }}"
            @endif

            {!! $attributes->merge([
                'class' => ($label ? 'mt-1 ' : '') . 'block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'
            ]) !!}>

            @if($placeholder)
                <option value="" disabled @if($nothingSelected()) selected="selected" @endif>
                    {{ $placeholder }}
                </option>
            @endif

            {!! $slot !!}

        @foreach($options as $key => $option)
            @if ($optionIsOptGroup($option))
                <optgroup label="{{ $optionLabel($option) }}">
                    @foreach ($optionChildren($option) as $child)
                    <option
                        value="{{ $optionValue($child) }}"
                        @selected($isSelected($optionValue($child)))
                        @disabled($optionIsDisabled($child))
                    >
                        {{ $optionLabel($child) }}
                    </option>
                    @endforeach
                </optgroup>
            @else
                <option
                    value="{{ $optionValue($option) }}"
                    @selected($isSelected($optionValue($option)))
                    @disabled($optionIsDisabled($option))
                >
                    {{ $optionLabel($option) }}
                </option>
            @endif
        @endforeach

        {{ $append ?? '' }}
        </select>
    </label>

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
