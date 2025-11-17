<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Ganti kolom status menjadi string biasa agar bisa menampung nilai tambahan seperti 'completed'.
        if (Schema::hasTable('visit_schedules') && Schema::hasColumn('visit_schedules', 'status')) {
            Schema::table('visit_schedules', function (Blueprint $table) {
                $table->string('status', 20)->default('available')->change();
            });
        }
    }

    public function down(): void
    {
        // Kembalikan ke enum awal jika ingin rollback.
        if (Schema::hasTable('visit_schedules') && Schema::hasColumn('visit_schedules', 'status')) {
            Schema::table('visit_schedules', function (Blueprint $table) {
                $table->enum('status', ['available', 'booked', 'closed'])->default('available')->change();
            });
        }
    }
};

