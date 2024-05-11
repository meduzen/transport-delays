<?php

use Database\Seeders\StibLineSeeder;
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
        Schema::create('stib_lines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city')->nullable();
            $table->json('direction')->nullable(); // STIB destination

            // Self-reference to line `id`
            $table->unsignedBigInteger('opposite_direction_id')->nullable(); // `id` in same table
            $table->foreign('opposite_direction_id')
                ->references('id')->on('stib_lines')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->json('various')->nullable(); // STIB direction
            $table->timestamps();
        });

        (new StibLineSeeder())->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stib_lines');
    }
};
