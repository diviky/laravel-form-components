<?php

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Concerns\HandlesBoundValues;
use Diviky\LaravelFormComponents\Concerns\HandlesDefaultAndOldValue;
use Diviky\LaravelFormComponents\Concerns\HandlesValidationErrors;
use Diviky\LaravelFormComponents\Concerns\HasExtraAttributes;
use Diviky\LaravelFormComponents\FormDataBinder;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;

abstract class Component extends BaseComponent
{
    use HandlesBoundValues;
    use HandlesDefaultAndOldValue;
    use HandlesValidationErrors;
    use HasExtraAttributes;

    /**
     * ID for this component.
     *
     * @var string
     */
    protected $id;

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $alias = Str::kebab(class_basename($this));

        $config = config("form-components.components.{$alias}");

        $framework = config('form-components.framework');

        return (string) str_replace('{framework}', $framework, $config['view']);
    }

    /**
     * Returns a boolean wether the form is wired to a Livewire component.
     */
    public function isWired(): bool
    {
        if (isset($this->attributes) && count($this->attributes->whereStartsWith('wire:model')->getIterator())) {
            return false;
        }

        return app(FormDataBinder::class)->isWired();
    }

    /**
     * The inversion of 'isWired()'.
     */
    public function isNotWired(): bool
    {
        return !$this->isWired();
    }

    /**
     * Returns the optional wire modifier.
     */
    public function wireModifier(): ?string
    {
        $modifier = app(FormDataBinder::class)->getWireModifier();

        return isset($modifier) ? ".{$modifier}" : null;
    }

    /**
     * Generates an ID, once, for this component.
     */
    public function id(): string
    {
        if ($this->id) {
            return $this->id;
        }

        if (isset($this->name)) {
            return $this->id = $this->generateIdByName() . '_' . Str::random(4);
        }

        return $this->id = Str::random(4);
    }

    public function entangle($attributes)
    {
        if (isset($attributes) && count($attributes->whereStartsWith('wire:model')->getIterator())) {
            return '$wire.entangle(\'' . $attributes->wire('model') . "')";
        }

        return json_encode($this->getValue());
    }

    public function wire()
    {
        if ($this->isWired()) {
            return 'wire:model' . $this->wireModifier() . '=' . $this->name;
        }

        return '';
    }

    /**
     * Generates an ID by the name attribute.
     */
    protected function generateIdByName(): string
    {
        return 'auto_id_' . trim(str_replace(['[', ']'], ['_', ''], $this->name), '_');
    }

    /**
     * Converts a bracket-notation to a dotted-notation
     *
     * @param  string  $name
     */
    protected static function convertBracketsToDots($name): string
    {
        return str_replace(['[', ']'], ['.', ''], Str::before($name, '[]'));
    }

    public function isReadonly(): bool
    {
        return $this->attributes->has('readonly') && $this->attributes->get('readonly') == true;
    }

    public function isRequired(): bool
    {
        return $this->attributes->has('required') && $this->attributes->get('required') == true;
    }

    public function isDisabled(): bool
    {
        return $this->attributes->has('disabled') && $this->attributes->get('disabled') == true;
    }
}
