<?php

namespace Diviky\LaravelFormComponents\Components;

class FormInputGroupText extends Component
{
    public bool $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $text = true)
    {
        $this->text = $text;
    }
}
