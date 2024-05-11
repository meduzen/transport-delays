<?php

use Database\Seeders\StibStopSeeder;
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
        Schema::create('stib_stops', function (Blueprint $table) {
            $table->id();
            $table->string('internal_id');
            $table->json('name')->nullable();
            $table->geography('coordinates', 'point')->nullable();
            $table->timestamps();
        });

        (new StibStopSeeder())->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stib_stops');
    }
};
