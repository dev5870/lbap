<?php

namespace App\Http\Filters;

class PaymentFilter extends QueryFilter
{
    public function user($value)
    {
        $this->builder->where('user_id', '=', $value);
    }
}
