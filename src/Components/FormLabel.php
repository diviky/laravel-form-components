<?php

namespace Diviky\LaravelFormComponents\Components;

class FormLabel extends Component
{
    public string $label;

    public string $hint;

    public mixed $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $label = '',
        string $hint = '',
        mixed $required = null
    ) {
        $this->label = $label;
        $this->required = $required;
        $this->hint = $hint;
    }
}
