<?php

declare(strict_types=1);

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Support\Timezone;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class TimezoneSelect extends FormSelect
{
    public function __construct(
        string $name,
        string $label = '',
        $options = [],
        $bind = null,
        $default = null,
        bool $multiple = false,
        bool $showErrors = true,
        bool $floating = false,
        string $placeholder = '',
        public ?string $valueField = 'id',
        public ?string $labelField = 'name',
        public ?string $disabledField = null,
        public ?string $childrenField = null,

        // Extra Attributes
        HtmlString|array|string|Collection|null $extraAttributes = null,

        // Timezone specific
        array|string|bool|null $only = null,
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
        $this->options = (new Timezone())->only($this->only)->allMapped();
    }
}
