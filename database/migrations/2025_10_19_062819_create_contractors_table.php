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
        if (! Schema::hasTable('contractors')) {
            Schema::create('contractors', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('email');
                $table->string('phone', 25);
                $table->string('alamat', 500);
                $table->string('luas_bangunan_lahan')->nullable();
                $table->string('titik_lokasi')->nullable();
                $table->text('pesan')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('contractors', function (Blueprint $table) {
            if (! Schema::hasColumn('contractors', 'nama')) {
                $table->string('nama')->after('id');
            }

            if (! Schema::hasColumn('contractors', 'email')) {
                $table->string('email')->after('nama');
            }

            if (! Schema::hasColumn('contractors', 'phone')) {
                $table->string('phone', 25)->after('email');
            }

            if (! Schema::hasColumn('contractors', 'alamat')) {
                $table->string('alamat', 500)->after('phone');
            }

            if (! Schema::hasColumn('contractors', 'luas_bangunan_lahan')) {
                $table->string('luas_bangunan_lahan')->nullable()->after('alamat');
            }

            if (! Schema::hasColumn('contractors', 'titik_lokasi')) {
                $table->string('titik_lokasi')->nullable()->after('luas_bangunan_lahan');
            }

            if (! Schema::hasColumn('contractors', 'pesan')) {
                $table->text('pesan')->nullable()->after('titik_lokasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractors');
    }
};
