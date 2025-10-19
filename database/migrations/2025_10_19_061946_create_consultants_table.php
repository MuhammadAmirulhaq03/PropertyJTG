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
        if (! Schema::hasTable('consultants')) {
            Schema::create('consultants', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('email');
                $table->string('phone', 25);
                $table->string('alamat', 500);
                $table->string('spesialisasi')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('consultants', function (Blueprint $table) {
            if (! Schema::hasColumn('consultants', 'nama')) {
                $table->string('nama')->after('id');
            }

            if (! Schema::hasColumn('consultants', 'email')) {
                $table->string('email')->after('nama');
            }

            if (! Schema::hasColumn('consultants', 'phone')) {
                $table->string('phone', 25)->after('email');
            }

            if (! Schema::hasColumn('consultants', 'alamat')) {
                $table->string('alamat', 500)->after('phone');
            }

            if (! Schema::hasColumn('consultants', 'spesialisasi')) {
                $table->string('spesialisasi')->nullable()->after('alamat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};
