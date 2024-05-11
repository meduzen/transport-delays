<?php

use Database\Seeders\StibLineAndStopSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stib_line_stib_stop', function (Blueprint $table) {
            $table->unsignedBigInteger('line_id');
            $table->unsignedBigInteger('stop_id');
            $table->integer('order');
            $table->timestamps();
        });

        (new StibLineAndStopSeeder())->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stib_line_stib_stop');
    }
};
