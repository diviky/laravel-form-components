<?php

namespace Diviky\LaravelFormComponents;

use Diviky\LaravelFormComponents\Concerns\HandlesBoundValues;
use Illuminate\Support\Arr;

class FormDataBinder
{
    use HandlesBoundValues;

    /**
     * Tree of bound targets.
     */
    protected array $bindings = [];

    /**
     * Wired to a Livewire component.
     */
    protected bool|string $wire = false;

    /**
     * Whether the default wire has been verified once.
     */
    protected bool $loadDefaultWire = true;

    /**
     * Bind a target to the current instance
     *
     * @param  mixed  $target
     */
    public function bind($target): void
    {
        $this->bindings[] = $target;
    }

    /**
     * Get the latest bound target.
     *
     * @return mixed
     */
    public function get()
    {
        return Arr::last($this->bindings);
    }

    /**
     * Remove the last binding.
     */
    public function pop(): void
    {
        array_pop($this->bindings);
    }

    /**
     * Returns wether the form is bound to a Livewire model.
     */
    public function isWired(): bool
    {
        if ($this->loadDefaultWire) {
            $this->loadDefaultWire = false;

            $defaultWire = config('form-components.default_wire');

            if ($defaultWire !== false) {
                $this->wire = $defaultWire;
            }
        }

        return $this->wire !== false;
    }

    /**
     * Returns the modifier, if set.
     */
    public function getWireModifier(): ?string
    {
        return is_string($this->wire) ? $this->wire : null;
    }

    /**
     * Enable Livewire binding with an optional modifier.
     *
     * @param  bool|string  $modifier
     */
    public function wire($modifier = null): void
    {
        $this->wire = $modifier !== false
            ? ($modifier ?: null)
            : false;

        $this->loadDefaultWire = false;
    }

    /**
     * Disable Livewire binding.
     */
    public function endWire(): void
    {
        $this->wire = false;

        $this->loadDefaultWire = true;
    }
}
