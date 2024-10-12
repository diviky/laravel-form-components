@if ($hasErrorAndShow($name))
    @error($name, $bag)
        <{{ $tag }} {!! $attributes->merge(['class' => 'invalid-feedback', 'id' => "{$inputId}-error"]) !!}>
            @if ($slot->isEmpty())
                {{ $message }}
            @else
                {{ $slot }}
            @endif
            </{{ $tag }}>
        @enderror
@endif
