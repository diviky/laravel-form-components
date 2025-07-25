<div class="flex flex-col">
    <label class="flex items-center">
        <input {!! $attributes->merge(['class' => 'rounded-sm border-gray-300 text-indigo-600 shadow-xs focus:border-indigo-300 focus:ring-3 focus:ring-offset-0 focus:ring-indigo-200/50']) !!}
            type="checkbox"
            value="{{ $value }}"

            @if($isWired())
                wire:model{!! $wireModifier() !!}="{{ $name }}"
            @endif

            name="{{ $name }}"

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
