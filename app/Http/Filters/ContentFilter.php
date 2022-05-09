<?php

namespace App\Http\Filters;

class ContentFilter extends QueryFilter
{
    public function title($value)
    {
        $this->builder->where('title', 'like', '%' . $value . '%');
    }
}
