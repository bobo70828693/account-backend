<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTradeLog extends Model
{
    protected $table = 'stock_trade_log';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function relationStockTradeMain()
    {
        return $this->belongsTo(StockTradeMain::class, 'stock_trade_main_id', 'id');
    }
}
