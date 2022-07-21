<?php

namespace App\Http\Filters;

class AddressFilter extends QueryFilter
{
    public function address($value)
    {
        $this->builder->where('address', 'like', '%' . $value . '%');
    }
}
