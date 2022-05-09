<?php

namespace App\Http\Filters;

class UserFilter extends QueryFilter
{
    public function email($value)
    {
        $this->builder->where('email', 'like', '%' . $value . '%');
    }
}
