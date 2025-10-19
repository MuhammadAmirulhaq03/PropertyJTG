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
        Schema::create('properti_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('properti_id')->constrained('propertis')->cascadeOnDelete();
            $table->string('disk')->default('public');
            $table->string('media_path');
            $table->enum('media_type', ['image', 'video']);
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->unsignedBigInteger('filesize')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properti_media');
    }
};

