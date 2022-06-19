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
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('symbol', 10);
            $table->decimal('quantity', 25, 10);
            $table->softDeletes();
            $table->timestamps();
        });

        \App\Models\Asset::query()
            ->updateOrCreate([
                'symbol' => \App\Constants\Symbol::BUSD,
            ], [
                'quantity' => 1000
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
};
