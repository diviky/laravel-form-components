<?php

namespace Diviky\LaravelFormComponents\Components;

class FormLabel extends Component
{
    public string $label;

    public mixed $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label = '', mixed $required = false)
    {
        $this->label = $label;
        $this->required = $required;
    }
}
