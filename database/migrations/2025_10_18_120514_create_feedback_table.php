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
    Schema::create('feedback', function (Blueprint $table) {
        $table->id();
        $table->unsignedTinyInteger('mood'); // 1 = sad, 2 = neutral, 3 = happy
        $table->unsignedTinyInteger('rating'); // 1–5 stars
        $table->text('message')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
