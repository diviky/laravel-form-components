<div>
    <label class="inline-flex items-center"></label>
        <input {!! $attributes->merge(['class' => 'rounded-full border-gray-300 text-indigo-600 shadow-xs focus:border-indigo-300 focus:ring-3 focus:ring-indigo-200/50']) !!}
            type="radio"

            @if($isWired())
                wire:model{!! $wireModifier() !!}="{{ $name }}"
            @endif

            name="{{ $name }}"
            value="{{ $value }}"

            @if($checked)
                checked="checked"
            @endif
        />

        <span class="ml-2">{{ $label }}</span>
    </label>

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
