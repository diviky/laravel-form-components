<?php

namespace Diviky\LaravelFormComponents\Components;

class FormInputGroup extends Component
{
    public string $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name = '', string $label = '', bool $showErrors = true)
    {
        $this->name = $name;
        $this->label = $label;
        $this->showErrors = $name && $showErrors;
    }
}
