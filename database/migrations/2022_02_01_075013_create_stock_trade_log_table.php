<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTradeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_trade_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stock_trade_main_id');
            $table->foreign('stock_trade_main_id')->references('id')->on('stock_trade_mains');
            $table->enum('action', ['in', 'out'])->comment('操作類型');
            $table->integer('num')->comment('股數');
            $table->float('income')->default(0)->comment('損益價值');
            $table->text('description')->nullable()->comment('說明');
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
        Schema::dropIfExists('stock_trade_log');
    }
}
