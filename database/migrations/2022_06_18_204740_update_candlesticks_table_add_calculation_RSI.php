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
            $table->decimal('calculation_RSI', 25, 5)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('candlesticks', function (Blueprint $table) {
            $table->dropColumn('calculation_RSI');
        });
    }
};
