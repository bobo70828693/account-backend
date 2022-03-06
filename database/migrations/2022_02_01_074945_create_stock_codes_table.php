<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_codes', function (Blueprint $table) {
            $table->string('stock_code')->primary()->comment('股票編號');
            $table->string('description', 100)->nullable()->comment('說明');
            $table->float('current_price')->default(0)->comment('目前價錢');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_codes');
    }
}
