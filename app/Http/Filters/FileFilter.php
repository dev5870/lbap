<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class FileFilter extends QueryFilter
{
    public function id($value)
    {
        $this->builder->whereHas('user', function (Builder $query) use ($value) {
            $query->where('id', $value);
        });
    }
}
