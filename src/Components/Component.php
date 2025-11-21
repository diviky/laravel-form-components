<?php

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Concerns\HandlesBoundValues;
use Diviky\LaravelFormComponents\Concerns\HandlesDefaultAndOldValue;
use Diviky\LaravelFormComponents\Concerns\HandlesValidationErrors;
use Diviky\LaravelFormComponents\Concerns\HasExtraAttributes;
use Diviky\LaravelFormComponents\FormDataBinder;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;
use Illuminate\View\ComponentAttributeBag;

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

    public ?string $name = null;

    public mixed $enabled = true;

    /**
     * {@inheritDoc}
     */
    #[\Override]
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
        $this->ensureAttribute();

        if (count($this->attributes->whereStartsWith('wire:model')->getIterator())) {
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

        if (!empty($this->name)) {
            return $this->id = $this->generateIdByName() . '_' . Str::random(4);
        }

        return $this->id = Str::random(4);
    }

    public function entangle(ComponentAttributeBag $attributes): string|false
    {
        if (count($attributes->whereStartsWith('wire:model')->getIterator())) {
            return '$wire.entangle(\'' . $attributes->wire('model') . "')" . $this->getWireModifier($attributes);
        }

        return json_encode($this->getValue());
    }

    protected function getWireModifier(ComponentAttributeBag $attributes): string
    {
        $key = array_key_first($attributes->whereStartsWith('wire:model')->getAttributes());

        if ($key && preg_match('/wire:model([^=]*)/', $key, $matches)) {
            if (!empty($matches[1])) {
                return $matches[1];
            }
        }

        return '';
    }

    public function wire(): string
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
        return 'auto_id_' . trim(str_replace(['[', ']'], ['_', ''], strval($this->name)), '_');
    }

    /**
     * Converts a bracket-notation to a dotted-notation
     */
    protected static function convertBracketsToDots(string $name): string
    {
        return str_replace(['[', ']'], ['.', ''], Str::before($name, '[]'));
    }

    public function isReadonly(): bool
    {
        return $this->attributes->has('readonly') && $this->attributes->get('readonly') == true;
    }

    public function isRequired(): bool
    {
        return $this->attributes->has('required')
        && ($this->attributes->get('required') == true
        || $this->attributes->get('required') == '1'
        );
    }

    public function isDisabled(): bool
    {
        return $this->attributes->has('disabled') && $this->attributes->get('disabled') == true;
    }

    protected function mergeAttributes(array $attributes): self
    {
        $this->ensureAttribute();

        $this->attributes = $this->attributes->merge($attributes);

        return $this;
    }

    /**
     * Set the extra attributes that the component should make available.
     *
     * @return $this
     */
    #[\Override]
    public function withAttributes(array $attributes)
    {
        $this->ensureAttribute();

        $all = $this->attributes->all();

        $this->attributes->setAttributes($attributes);
        $this->mergeAttributes($all);

        return $this;
    }

    protected function ensureAttribute(): void
    {
        $this->attributes = $this->attributes ?: $this->newAttributeBag();
    }

    public function shouldRender()
    {
        return $this->enabled;
    }
}
