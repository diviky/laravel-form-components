<div class="form-group position-relative"
    @if ($attributes->has('count')) x-data="{
        charCount: {{ strlen($value ?? '') }},
        maxLength: {{ $attributes->get('count') }},
        updateCount(event) {
            this.charCount = event.target.value.length;
        },
        init() {
            this.updateCharCount();
        },
        updateCharCount() {
            this.$nextTick(() => {
                const textarea = this.$el.querySelector('textarea');
                if (textarea) {
                    this.charCount = textarea.value.length;
                }
            });
        }
    }"
    x-init="init()" x-effect="updateCharCount()" @endif>
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$id()" />
    @endif

    @isset($before)
        {!! $before !!}
    @endisset
    <div class="position-relative">
        <textarea {!! $attributes->except(['extra-attributes'])->merge([
                'name' => $inputName(),
                'id' => $id(),
                'placeholder' => '',
            ])->class([
                'form-control' => true,
                'form-control-color' => $type === 'color',
                'form-control-sm' => $size == 'sm',
                'form-control-lg' => $size == 'lg',
                'is-invalid' => $hasError($inputName()),
            ]) !!} {{ $wire() }} {{ $extraAttributes ?? '' }}
            @if ($attributes->has('count')) @input="updateCount($event)" @endif>{!! $value !!}</textarea>

        @if ($attributes->has('count'))
            <div class="form-text text-muted text-sm position-absolute top-0 end-0 pr-2"
                x-text="`${charCount}/${maxLength}`">
            </div>
        @endif
    </div>

    @isset($after)
        {!! $after !!}
    @endisset

    @if ($floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$id()" />
    @endif

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
<x-form-errors :name="$inputName()" />
</div>
