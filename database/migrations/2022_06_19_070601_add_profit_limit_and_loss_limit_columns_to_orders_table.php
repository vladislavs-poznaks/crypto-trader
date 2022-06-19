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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('profit_limit_price', 25, 10)
                ->after('sell_price')
                ->nullable();

            $table->decimal('loss_limit_price', 25, 10)
                ->after('sell_price')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('loss_limit_price');
            $table->dropColumn('profit_limit_price');
        });
    }
};
