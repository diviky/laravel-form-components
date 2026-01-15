@if ($all)
    @foreach ($getMessages() as $message)
        <{{ $tag }} {!! $attributes->merge(['class' => 'invalid-feedback show', 'id' => "{$inputId}-error"]) !!}>
            @if ($slot->isEmpty())
                {{ $message }}
            @else
                {{ $slot }}
            @endif
            </{{ $tag }}>
    @endforeach
@elseif ($hasErrorAndShow($inputErrorName))
    @error($inputErrorName, $bag)
        <{{ $tag }} {!! $attributes->merge(['class' => 'invalid-feedback show', 'id' => "{$inputId}-error"]) !!}>
            @if ($slot->isEmpty())
                {{ $message }}
            @else
                {{ $slot }}
            @endif
            </{{ $tag }}>
        @enderror
@endif
