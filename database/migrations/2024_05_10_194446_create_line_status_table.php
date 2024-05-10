<?php

use Database\Seeders\StibSampleLineStatusSeeder;
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
        Schema::create('line_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id');
            $table->foreignId('line_id');
            $table->timestamps();
        });

        (new StibSampleLineStatusSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_status');
    }
};
