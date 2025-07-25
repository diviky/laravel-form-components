<div class="mt-4">
    <label class="block">
        <x-form-label :label="$label" />

        <textarea
            @if($isWired())
                wire:model{!! $wireModifier() !!}="{{ $name }}"
            @endif

            name="{{ $name }}"

            {!! $attributes->merge(['class' => 'block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-300 focus:ring-3 focus:ring-indigo-200/50' . ($label ? ' mt-1' : '')]) !!}
        >@unless($isWired()){!! $value !!}@endunless</textarea>
    </label>

    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
