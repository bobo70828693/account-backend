<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTradeMain extends Model
{
    protected $table = 'stock_trade_mains';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function relationStockCode()
    {
        return $this->belongsTo(StockCode::class, 'stock_code', 'stock_code');
    }

    public function relationStockTradeLog()
    {
        return $this->hasMany(StockTradeLog::class, 'id', 'stock_trade_main_id');
    }
}
