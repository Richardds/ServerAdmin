<?php

namespace Richardds\ServerAdmin\Scopes\Local;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Toggles
 * @package Richardds\ServerAdmin\Scopes\Local
 */
trait Toggles
{
    /**
     * Scope a query to only include enabled rows.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled(Builder $query)
    {
        return $query->where('enabled', '=', true);
    }
}
