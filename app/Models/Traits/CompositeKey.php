<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CompositeKey
{
    /**
     * Here we are going to be overriding everything to do with the model itself; and this is just going to be checking
     * whether or not the model at hand has a composite key, and if not, just return the normal happening of being
     * able to save a query, otherwise, find all the keys that are assigned to the model at hand, and then building
     * a saving query regarding all the keys that have been applied.
     *
     * @param Builder $query
     * @return Builder
     */
    protected function setKeysForSaveQuery($query): Builder
    {
        // if the key type of a string, then we are just going to return the normal method of the save parameters.
        if (gettype($keys = $this->getKeyName()) === 'string')
            return $query->where($keys, '=', $this->getAttribute($this->getKeyName()));

        // if the key type has been designated an array; then we are going to be walking over the keys that are assigned
        // against the model in question, and then apply that to what is going to be attempted to eb saved against; this
        // method should allow for a composite key of more than 1 keys, and going up to an endless amount of keys...
        array_walk($keys, function ($column) use (&$query) {
            $query->where($column, '=', $this->getAttribute($column));
        });

        return $query;
    }
}
