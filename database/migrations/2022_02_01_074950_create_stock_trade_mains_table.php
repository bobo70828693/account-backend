<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTradeMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_trade_mains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stock_code')->comment('股票編號');
            $table->foreign('stock_code')->references('stock_code')->on('stock_codes');
            $table->string('status')->comment('狀態');
            $table->integer('num')->comment('股數');
            $table->float('price')->default(0)->comment('成交金額');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_trade_mains');
    }
}
