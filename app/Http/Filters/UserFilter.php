<?php

namespace App\Http\Filters;

class UserFilter extends QueryFilter
{
    public function email($value)
    {
        $this->builder->where('email', 'like', '%' . $value . '%');
    }

    public function createdFrom($value)
    {
        $this->createdFrom = $value;
        $this->builder->whereBetween('created_at', [$value . '%', date('Y-m-d') . '%']);
    }

    public function createdTo($value)
    {
        if (!empty($this->createdFrom)) {
            $this->builder->whereBetween('created_at', [$this->createdFrom . '%', $value . ' 23:59:59%']);
        } else {
            $this->builder->where('created_at', '<', $value);
        }
    }
}
