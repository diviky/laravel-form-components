<?php

namespace Diviky\LaravelFormComponents\Components;

class FormSubmit extends Component
{
    public string $outline = '';

    public function __construct(
        bool $outline = false,
        public bool $ghost = false,
        public bool $plain = false,
        public bool $disabled = false,
    ) {
        $this->outline = $outline ? 'outline-' : ($ghost ? 'ghost-' : '');
        $this->disabled = boolval($disabled);
    }
}
