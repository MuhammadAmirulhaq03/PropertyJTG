<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('contractors', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('email');
        $table->string('phone');
        $table->text('alamat');
        $table->string('luas_bangunan_lahan')->nullable();
        $table->string('titik_lokasi')->nullable();
        $table->text('pesan')->nullable();
        $table->timestamps();
    });
}
};
