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
        Schema::create('transfer_volume_sums', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('code', 15);
            $table->decimal('value', 25, 15);
            $table->timestamp('timestamp');
            $table->string('range', 15);
            $table->decimal('calculation_index', 25, 15)->nullable()->default(null);
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
        Schema::dropIfExists('transfer_volume_sums');
    }
};
