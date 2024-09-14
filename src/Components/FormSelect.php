<?php

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Concerns\GetsSelectOptionProperties;
use Diviky\LaravelFormComponents\Concerns\HandlesBoundValues;
use Diviky\LaravelFormComponents\Concerns\HandlesValidationErrors;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class FormSelect extends Component
{
    use GetsSelectOptionProperties;
    use HandlesBoundValues;
    use HandlesValidationErrors;

    public string $name;

    public string $label;

    public array|Collection|null $options;

    public mixed $selectedKey;

    public bool $multiple;

    public bool $floating;

    public string $placeholder;

    public string $selectedKeys;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $label = '',
        array|Collection|null $options = [],
        mixed $bind = null,
        mixed $default = null,
        bool $multiple = false,
        bool $showErrors = true,
        bool $floating = false,
        string $placeholder = '',
        public ?string $valueField = null,
        public ?string $labelField = null,
        public ?string $disabledField = null,
        public ?string $childrenField = null,
        public ?array $settings = [],
        string|HtmlString|array|Collection|null $extraAttributes = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->setExtraAttributes($extraAttributes);

        if ($this->isNotWired()) {
            $inputName = static::convertBracketsToDots(Str::before($name, '[]'));

            if (is_null($default)) {
                $default = $this->getBoundValue($bind, $inputName);
            }

            $this->selectedKey = old($inputName, $default);

            if ($this->selectedKey instanceof Arrayable) {
                $this->selectedKey = $this->selectedKey->toArray();
            }
        }

        $this->selectedKey = Arr::wrap($this->selectedKey);
        $this->selectedKeys = implode(',', $this->selectedKey);
        $this->multiple = $multiple;
        $this->showErrors = $showErrors;
        $this->floating = $floating && !$multiple;

        $this->valueField = $valueField ?? ((is_array($extraAttributes) && isset($extraAttributes['value-field'])) ? $extraAttributes['value-field'] : 'id');
        $this->labelField = $labelField ?? ((is_array($extraAttributes) && isset($extraAttributes['label-field'])) ? $extraAttributes['label-field'] : 'text');
        $this->disabledField = $disabledField ?? 'disabled';
        $this->childrenField = $childrenField ?? 'children';

        $this->options = $this->normalizeOptions($options);
    }

    public function isSelected($key): bool
    {
        if ($this->isWired()) {
            return false;
        }

        return in_array($key, Arr::wrap($this->selectedKey));
    }

    public function nothingSelected(): bool
    {
        if ($this->isWired()) {
            return false;
        }

        return is_array($this->selectedKey) ? empty($this->selectedKey) : is_null($this->selectedKey);
    }

    protected function normalizeOptions(array|Collection|null $options): Collection
    {
        if (is_null($options)) {
            return collect([]);
        }

        if (!is_array($options)) {
            $options = $options->toArray();
        }

        $isList = Arr::isList($options);

        return collect($options)
            ->map(function ($value, $key) use ($isList) {
                // If the key is not numeric, we're going to assume this is the value.
                if (!is_numeric($key) || !$isList) {
                    return [
                        $this->valueField => $key,
                        $this->labelField => $value,
                    ];
                }

                // If the value is a simple value, we need to convert it to an array.
                if (!is_iterable($value) && !$value instanceof Model) {
                    return [
                        $this->valueField => $value,
                        $this->labelField => $value,
                    ];
                }

                return $value;
            });
    }
}
