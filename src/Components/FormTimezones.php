<?php

declare(strict_types=1);

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Support\Timezone;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class FormTimezones extends FormSelect
{
    public function __construct(
        string $name,
        string $label = '',
        mixed $options = [],
        mixed $bind = null,
        mixed $default = null,
        bool $multiple = false,
        bool $showErrors = true,
        bool $floating = false,
        string $placeholder = '',
        public ?string $valueField = 'id',
        public ?string $labelField = 'name',
        public ?string $disabledField = null,
        public ?string $childrenField = null,

        // Extra Attributes
        public ?array $settings = [],
        HtmlString|array|string|Collection|null $extraAttributes = null,

        // Timezone specific
        public array|string|bool|null $only = null,
    ) {
        parent::__construct(
            name: $name,
            label: $label,
            options: $options,
            bind: $bind,
            default: $default,
            multiple: $multiple,
            showErrors: $showErrors,
            floating: $floating,
            placeholder: $placeholder,
            valueField: $valueField,
            labelField: $labelField,
            disabledField: $disabledField,
            childrenField: $childrenField,
            extraAttributes: $extraAttributes,
        );

        $this->only = $only ?? false;
        $this->options = (new Timezone)->only($this->only)->allMapped();
    }
}
