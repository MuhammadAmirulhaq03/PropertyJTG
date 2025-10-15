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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'agen', 'customer'])->default('customer')->after('password');
            $table->string('phone')->nullable()->after('role');
            $table->text('alamat')->nullable()->after('phone');
            $table->string('foto_profil')->nullable()->after('alamat');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('foto_profil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'alamat', 'foto_profil', 'status']);
        });
    }
};
