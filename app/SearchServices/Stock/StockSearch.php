<?php

namespace App\SearchServices\Stock;

use App\Models\StockTradeLog;
use App\SearchServices\ISearchService;
use App\SearchServices\SearchService;

class StockSearch extends SearchService implements ISearchService
{
    public static function apply($filters, $sort_str = 'id|asc', $use_page = 1)
    {
        $sort = explode('|', $sort_str);
        $query = SearchService::applyDecoratorsFromRequest(
            $filters,
            (new StockTradeLog())
                ->with([
                    'relationStockTradeMain',
                    'relationStockTradeMain.relationStockCode'
                ])
                ->orderBy($sort[0], $sort[1])
                ->newQuery(),
            __NAMESPACE__,
            'Filters'
        );

        return ($use_page) ? SearchService::pageResults(
            $query,
            $filters['per_page']
        ) : SearchService::getResults($query);
    }
}
