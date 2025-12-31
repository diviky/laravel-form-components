<div class="form-group position-relative"
    @if ($attributes->has('length')) x-data="{
        charCount: {{ strlen($value ?? '') }},
        maxLength: {{ $attributes->get('length') }},
        updateCount(event) {
            this.charCount = event.target.value.length;
        }
    }"
    x-init="charCount = $el.querySelector('textarea')?.value?.length || 0" @endif>
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @isset($before)
        {!! $before !!}
    @endisset
    <div class="position-relative">
        <textarea {!! $attributes->except(['extra-attributes'])->merge([
                'name' => $name,
                'id' => $id(),
                'placeholder' => '',
            ])->class([
                'form-control' => true,
                'form-control-color' => $type === 'color',
                'form-control-sm' => $size == 'sm',
                'form-control-lg' => $size == 'lg',
                'is-invalid' => $hasError($name),
            ]) !!} {{ $wire() }} {{ $extraAttributes ?? '' }}
            @if ($attributes->has('length')) @input="updateCount($event)" @endif>{!! $value !!}</textarea>

        @if ($attributes->has('length'))
            <div class="form-text text-muted text-sm position-absolute top-0 end-0 pr-2"
                x-text="`${charCount}/${maxLength}`">
            </div>
        @endif
    </div>

    @isset($after)
        {!! $after !!}
    @endisset

    @if ($floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
<x-form-errors :name="$name" />
</div>
