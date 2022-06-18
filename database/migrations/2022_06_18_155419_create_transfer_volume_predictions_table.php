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
        Schema::create('transfer_volume_predictions', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('symbol', 15);
            $table->string('range', 15);
            $table->timestamp('date');
            $table->decimal('value', 25, 15);
            $table->string('size', 15);
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
        Schema::dropIfExists('transfer_volume_predictions');
    }
};
