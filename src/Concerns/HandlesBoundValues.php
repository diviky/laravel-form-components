<?php

namespace Diviky\LaravelFormComponents\Concerns;

use DateTimeInterface;
use Diviky\LaravelFormComponents\FormDataBinder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use stdClass;

trait HandlesBoundValues
{
    /**
     * Wether to retrieve the default value as a single
     * attribute or as a collection from the database.
     *
     * @var bool
     */
    protected $manyRelation = false;

    /**
     * Get an instance of FormDataBinder.
     */
    private function getFormDataBinder(): FormDataBinder
    {
        return app(FormDataBinder::class);
    }

    /**
     * Get the latest bound target.
     *
     * @return mixed
     */
    private function getBoundTarget()
    {
        return $this->getFormDataBinder()->get();
    }

    /**
     * Get an item from the latest bound target.
     *
     * @param  mixed  $bind
     * @return mixed
     */
    private function getBoundValue($bind, string $name)
    {
        if ($bind === false) {
            return null;
        }

        $bind = $bind ?: $this->getBoundTarget();

        if ($this->manyRelation) {
            return $this->getAttachedKeysFromRelation($bind, $name);
        }

        if ($bind instanceof Collection) {
            $bind = $bind->toArray();
        }

        if ($bind instanceof stdClass && method_exists($bind, 'toArray')) {
            $bind = $bind->toArray();
        }

        if ($bind instanceof stdClass) {
            $bind = json_decode(json_encode($bind), true);
        }

        $boundValue = data_get($bind, $name);

        if ($bind instanceof Model && $boundValue instanceof DateTimeInterface) {
            return $this->formatDateTime($bind, $name, $boundValue);
        }

        return $boundValue;
    }

    /**
     * Formats a DateTimeInterface if the key is specified as a date or datetime in the model.
     *
     * @return mixed
     */
    private function formatDateTime(Model $model, string $key, DateTimeInterface $date)
    {
        if (!config('form-components.use_eloquent_date_casting')) {
            return $date;
        }

        $cast = $model->getCasts()[$key] ?? null;

        if (!$cast || $cast === 'date' || $cast === 'datetime') {
            return Carbon::instance($date)->toJSON();
        }

        if ($this->isCustomDateTimeCast($cast)) {
            return $date->format(explode(':', $cast, 2)[1]);
        }

        return $date;
    }

    /**
     * Determine if the cast type is a custom date time cast.
     *
     * @param  string  $cast
     * @return bool
     */
    protected function isCustomDateTimeCast($cast)
    {
        return Str::startsWith($cast, [
            'date:',
            'datetime:',
            'immutable_date:',
            'immutable_datetime:',
        ]);
    }

    /**
     * Returns an array with the attached keys.
     *
     * @param  mixed  $bind
     * @return mixed
     */
    private function getAttachedKeysFromRelation($bind, string $name): ?array
    {
        if (!$bind instanceof Model) {
            return data_get($bind, $name);
        }

        $relation = $bind->{$name}();

        if ($relation instanceof BelongsToMany) {
            $relatedKeyName = $relation->getRelatedKeyName();

            return $relation->getBaseQuery()
                ->get($relation->getRelated()->qualifyColumn($relatedKeyName))
                ->pluck($relatedKeyName)
                ->all();
        }

        if ($relation instanceof MorphMany) {
            $parentKeyName = $relation->getLocalKeyName();

            return $relation->getBaseQuery()
                ->get($relation->getQuery()->qualifyColumn($parentKeyName))
                ->pluck($parentKeyName)
                ->all();
        }

        return data_get($bind, $name);
    }
}
