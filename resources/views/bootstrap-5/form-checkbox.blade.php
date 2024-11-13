<div>
    @if ($attributes->has('title'))
        <div class="mb-2 text-bold">{{ $attributes->get('title') }}</div>
    @endif

    <div class="form-check @if (null !== $attributes->get('inline')) form-check-inline @endif">
        @if ($copy !== false)
            <input type="hidden" value="{{ $copy }}" name="{{ $name }}" />
        @endif

        <input {!! $attributes->except(['extra-attributes'])->class([
                'is-invalid' => $hasError($name),
            ])->merge([
                'class' => 'form-check-input',
                'id' => $id(),
                'name' => $name,
                'type' => 'checkbox',
                'value' => $value,
            ]) !!} {{ $extraAttributes ?? '' }} {{ $wire() }} @checked($checked) />

        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" class="form-check-label" />

        <span class="form-check-description">
            <x-help> {!! $help ?? null !!} </x-help>
        </span>
    </div>

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
