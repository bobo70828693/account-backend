<?php

namespace App\SearchServices;

use Illuminate\Database\Eloquent\Builder;

interface IFilter
{
    public static function apply(Builder $builder, $value);
}
