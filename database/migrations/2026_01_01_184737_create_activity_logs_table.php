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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_log_id')->constrained()->onDelete('cascade');
            $table->string('activity_category');
            $table->string('activity_type')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->unsignedTinyInteger('intensity')->nullable();
            $table->unsignedTinyInteger('perceived_load')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('activity_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
