<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class FileFilter extends QueryFilter
{
    public function id($value)
    {
        $this->builder
            ->whereRelation('user', function (Builder $query) use ($value) {
                $query->where('id', 'like', '%' . $value . '%');
            })
            ->orWhereRelation('content', function (Builder $query) use ($value) {
                $query->where('id', 'like', '%' . $value . '%');
            });
    }
}
