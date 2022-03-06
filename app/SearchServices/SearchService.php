<?php

namespace App\SearchServices;

use Illuminate\Database\Eloquent\Builder;

abstract class SearchService
{
    public static function applyDecoratorsFromRequest($request, Builder $query, $name_space, $filter_folder)
    {
        foreach ($request as $filterName => $value) {
            if ($filterName != 'status_in' && $value == null) {
                continue;
            }
            $decorator = static::createFilterDecorator($filterName, $name_space, $filter_folder);
            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }

        return $query;
    }

    private static function createFilterDecorator($name, $name_space, $filter_folder)
    {
        return $name_space.'\\'.$filter_folder.'\\'.
            str_replace(
                ' ',
                '',
                ucwords(str_replace('_', ' ', $name))
            );
    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    public static function pageResults(Builder $query, $per_page)
    {
        return $query->paginate($per_page);
    }

    public static function getResults(Builder $query)
    {
        return $query->get();
    }
}
