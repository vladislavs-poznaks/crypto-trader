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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('side', 5);
            $table->string('type', 5);
            $table->string('status')
                ->nullable();
            $table->string('code', 10);
            $table->unsignedBigInteger('order_id');
            $table->string('client_order_id', 30);
            $table->decimal('price', 25, 10);
            $table->decimal('ordered_quantity', 25, 10);
            $table->decimal('executed_quantity', 25, 10)
                ->default(0);
            $table->decimal('commission', 25, 10)
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
