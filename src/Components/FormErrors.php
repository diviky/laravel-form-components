<?php

namespace Diviky\LaravelFormComponents\Components;

class FormErrors extends Component
{
    public string $bag;

    public string $inputErrorName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $bag = 'default',
        public ?string $tag = null,
        public ?string $inputId = null,
        public bool $all = false,
    ) {
        $this->inputErrorName = static::convertBracketsToDots($name);

        $this->inputId = $inputId ?? $this->name;
        $this->tag = $tag ?? 'div';
        $this->bag = $bag;
    }
}
