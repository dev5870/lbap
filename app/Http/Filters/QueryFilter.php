<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $this->setBuilder($builder);

        foreach ($this->fields() as $field => $value) {
            $method = Str::camel($field);
            if (method_exists($this, $method) && !empty($value)) {
                call_user_func_array([$this, $method], (array)$value);
            }
        }
    }

    protected function setBuilder(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        return $this->request->all();
    }
}
