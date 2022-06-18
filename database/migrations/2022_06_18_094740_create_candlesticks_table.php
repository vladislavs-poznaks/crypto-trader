<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candlesticks', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('code', 10);
            $table->string('range', 10);
            $table->decimal('open', 25, 10);
            $table->decimal('close', 25, 10);
            $table->decimal('close_open_difference', 25, 10);
            $table->decimal('low', 25, 10);
            $table->decimal('high', 25, 10);
            $table->decimal('high_low_difference', 25, 10);
            $table->decimal('volume', 25, 5);
            $table->timestamp('open_time');
            $table->timestamp('close_time');
            $table->decimal('asset_volume', 25, 5);
            $table->decimal('base_volume', 25, 5);
            $table->unsignedBigInteger('trades');
            $table->decimal('asset_buy_volume', 25, 5);
            $table->decimal('taker_buy_volume', 25, 5);
            $table->boolean('ignored');
            $table->decimal('calculation_RSI', 25, 5)->nullable()->default(null);
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
        Schema::dropIfExists('candlesticks');
    }
};
