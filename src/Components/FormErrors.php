<?php

namespace Diviky\LaravelFormComponents\Components;

use Illuminate\Support\Str;

class FormErrors extends Component
{
    public string $name;

    public string $bag;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $bag = 'default',
        public ?string $tag = null,
        public ?string $inputId = null,
    ) {
        $this->name = static::convertBracketsToDots(Str::before($name, '[]'));
        $this->inputId = $inputId ?? $this->name;
        $this->tag = $tag ?? 'div';
        $this->bag = $bag;
    }
}
