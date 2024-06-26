<?php

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
        Schema::create('stib_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('priority');
            $table->boolean('active')->default(true);
            $table->string('type');
            $table->json('content');
            $table->timestamps();
            $table->timestamp('ended_at')->nullable();
            $table->json('raw');

            $table->index('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stib_statuses');
    }
};
