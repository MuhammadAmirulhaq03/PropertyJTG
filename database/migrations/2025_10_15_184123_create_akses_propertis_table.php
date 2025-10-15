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
        Schema::create('akses_propertis', function (Blueprint $table) {
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('properti_id')->constrained('propertis')->onDelete('cascade');
            $table->primary(['customer_id', 'properti_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akses_propertis');
    }
};
