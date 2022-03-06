<?php

namespace App\Services;

use App\Repositories\StockTradeLogRepository;
use App\Repositories\StockTradeMainRepository;
use App\SearchServices\Stock\StockSearch;

class StockService
{
    private $stockSearch;
    private $stockTradeMainRepository;
    private $stockTradeLogRepository;

    public function __construct(
        StockSearch $stockSearch,
        StockTradeMainRepository $stockTradeMainRepository,
        StockTradeLogRepository $stockTradeLogRepository
    ) {
        $this->stockSearch = $stockSearch;
        $this->stockTradeMainRepository = $stockTradeMainRepository;
        $this->stockTradeLogRepository = $stockTradeLogRepository;
    }

    public function stockSearch($request)
    {
        $input = [
            'per_page' => $request['per_page'] ?? 10
        ];
        $use_page = $request['use_page'] ?? 1;
        $sort = $request['sort'] ?? 'id|asc';

        $stock_list_data = $this->stockSearch->apply($input, $sort, $use_page);

        return $stock_list_data;
    }

    public function storeStockTradeMain($request)
    {
        $main_data = [
            'stock_code' => $request['stock_code'],
            'num'        => $request['num'],
            'price'      => $request['price'],
        ];

        $main_id = $this->stockTradeMainRepository->create($main_data)['id'];

        $this->storeStockTradeLog($main_id, [
            'num'         => $request['num'],
            'price'       => $request['price'],
            'description' => $request['description'],
            'action'      => $request['action'],
        ]);
    }

    public function storeStockTradeLog($st_main_id, $trade_data)
    {
        $trade_log_data = [
            'stock_trade_main_id' => $st_main_id,
            'action'              => $trade_data['action'],
            'num'                 => $trade_data['num'],
            'income'              => $this->calcStockIncome($st_main_id, $trade_data['num'], $trade_data['price'], $trade_data['action']),
            'description'         => $trade_data['description'],
        ];

        $this->stockTradeLogRepository->create($trade_log_data);
    }

    private function calcStockIncome($st_main_id, $num, $price, $action = 'in')
    {
        $income = 0;

        if ($action == 'in') {
            $income = 0 - $num * $price;
        } else if ($action == 'out') {

        }

        return $income;
    }
}
