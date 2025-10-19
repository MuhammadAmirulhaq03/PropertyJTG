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
        if (! Schema::hasTable('consultation_schedules')) {
            Schema::create('consultation_schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('nama_konsultan');
                $table->date('tanggal');
                $table->time('waktu');
                $table->text('catatan')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('consultation_schedules', function (Blueprint $table) {
            if (! Schema::hasColumn('consultation_schedules', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }

            if (! Schema::hasColumn('consultation_schedules', 'nama_konsultan')) {
                $table->string('nama_konsultan')->after('user_id');
            }

            if (! Schema::hasColumn('consultation_schedules', 'tanggal')) {
                $table->date('tanggal')->after('nama_konsultan');
            }

            if (! Schema::hasColumn('consultation_schedules', 'waktu')) {
                $table->time('waktu')->after('tanggal');
            }

            if (! Schema::hasColumn('consultation_schedules', 'catatan')) {
                $table->text('catatan')->nullable()->after('waktu');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_schedules');
    }
};
