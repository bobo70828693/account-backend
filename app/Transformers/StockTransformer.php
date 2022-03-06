<?php

namespace App\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

class StockTransformer
{
    public function index($data, $per_page)
    {
        $per_page = $per_page ?? 10;
        $totalRecordAmount = $data->total();
        $data = $data->items();
        $result = [];
        foreach ($data as $value) {
            array_push($result, $this->transformer($value));
        }

        return new LengthAwarePaginator($result, $totalRecordAmount, (int)$per_page);
    }

    public function transformer($data)
    {
        $result = [
            'stock_info'  => [
                'stock_code'  => $data['relationStockTradeMain']['relationStockCode']['stock_code'],
                'description' => $data['relationStockTradeMain']['relationStockCode']['description']
            ],
            'action'      => $data['action'],
            'price'       => $data['price'],
            'income'      => $data['income'],
            'num'         => $data['num'],
            'description' => $data['description'],
            'created_at'  => $data['created_at']->format('Y-m-d H:i:s')
        ];

        return $result;
    }

    public function stockCodeTransformer($data)
    {
        $result = [];
        foreach ($data as $one_data) {
            array_push($result, [
                'stock_code'    => $one_data['stock_code'],
                'description'   => $one_data["description"],
                'current_price' => $one_data['current_price']
            ]);
        }

        return $result;
    }
}
