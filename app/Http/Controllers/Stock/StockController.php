<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Repositories\StockCodeRepository;
use App\Repositories\StockTradeLogRepository;
use App\Services\StockService;
use App\Transformers\StockTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    private $stockService;
    private $stockTransformer;
    private $stockCodeRepository;
    private $stockTradeLogRepository;

    public function __construct(
        StockService $stockService,
        StockTransformer $stockTransformer,
        StockCodeRepository $stockCodeRepository,
        StockTradeLogRepository $stockTradeLogRepository
    ) {
        $this->stockService = $stockService;
        $this->stockTransformer = $stockTransformer;
        $this->stockCodeRepository = $stockCodeRepository;
        $this->stockTradeLogRepository = $stockTradeLogRepository;
    }

    public function index(Request $request)
    {
        $search_data = [
            'per_page' => $request['per_page'] ?? 10,
            'use_page' => $request['use_page'] ?? 1,
        ];
        $search_result = $this->stockService->stockSearch($search_data);
        $result_transformer = $this->stockTransformer->index($search_result, $search_data['per_page']);

        return $this->responseMaker($result_transformer);
    }

    public function getStockCodeList(Request $request)
    {
        $search_stock_code_result = $this->stockCodeRepository->getAll([]);
        $result_transformer = $this->stockTransformer->stockCodeTransformer($search_stock_code_result);

        return $this->responseMaker($result_transformer);
    }

    public function store(Request $request)
    {
        $validator_data = [
            'stock_code'  => 'required',
            'action'      => 'required|in:in,out',
            'num'         => 'required|integer',
            'price'       => 'required',
            'description' => 'string|nullable'
        ];

        $validator = Validator::make($request->all(), $validator_data);

        if ($validator->fails()) {
            return $this->responseMaker($validator->messages(), 403);
        }

        $this->stockService->storeStockTradeMain($request);

        return $this->responseMaker(null, 205);
    }

    public function update()
    {
    }

    public function destroy()
    {
    }

    public function show()
    {
    }
}
