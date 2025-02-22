<?php

declare(strict_types=1);

namespace Diviky\LaravelFormComponents\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

trait HasExtraAttributes
{
    public ?HtmlString $extraAttributes = null;

    public array $properties = [];

    protected function setExtraAttributes(null|string|HtmlString|array|Collection $attributes): void
    {
        $this->ensureAttribute();

        if (is_null($attributes)) {
            return;
        }

        if (is_iterable($attributes)) {
            $this->properties = $attributes;
            $this->mergeAttributes(collect($attributes)->filter()->toArray());
        }

        if ($attributes instanceof Collection) {
            $this->extraAttributes = $this->getExtraAttributesFromIterable($attributes);

            return;
        }

        $this->extraAttributes = is_iterable($attributes)
            ? $this->getExtraAttributesFromIterable($attributes)
            : $this->getExtraAttributesFromString($attributes);
    }

    protected function getExtraAttributesFromIterable(array|Collection $attributes): HtmlString
    {
        $attributes = collect($attributes)
            ->filter()
            ->map(fn ($value, $key) => "{$key}=\"{$value}\"")
            ->implode(PHP_EOL);

        return new HtmlString($attributes);
    }

    protected function getExtraAttributesFromString(string|HtmlString $attributes): HtmlString
    {
        return $attributes instanceof HtmlString ? $attributes : new HtmlString($attributes);
    }
}
