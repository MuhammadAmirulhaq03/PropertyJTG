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
        Schema::create('kalkulator_kprs', function (Blueprint $table) {
            $table->id();
            $table->double('pendapatan_bulanan');
            $table->double('harga_properti');
            $table->double('dp');
            $table->integer('tenor');
            $table->string('tipe_uang', 20)->nullable();
            $table->double('hasil_simulasi')->nullable();
            $table->boolean('validasi')->default(false);
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalkulator_k_p_r_s');
    }
};
