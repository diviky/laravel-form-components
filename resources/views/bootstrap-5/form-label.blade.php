@if ($label)
    <label {!! $attributes->merge(['class' => 'form-label']) !!}>
        <span
            @if ($attributes->has('title')) class="text-underline" data-bs-toggle="tooltip" title="{{ $attributes->get('title') }}" @endif>
            {{ $label }}

            @if ($required)
                <span class="text-small">(required)</span>
            @else
                <span class="text-small">(optional)</span>
            @endif
        </span>

        @if ($hint)
            <span class="cursor-help" data-bs-toggle="tooltip" title="{!! $hint !!}">
                <x-icon name="help" />
            </span>
        @endif

        @isset($description)
            <div class="form-label-description">{!! $description !!}</div>
        @endisset
    </label>
@endif
