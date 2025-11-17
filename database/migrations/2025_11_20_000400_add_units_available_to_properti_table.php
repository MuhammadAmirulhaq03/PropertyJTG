<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('propertis') && ! Schema::hasColumn('propertis', 'units_available')) {
            Schema::table('propertis', function (Blueprint $table) {
                $table->unsignedInteger('units_available')->nullable()->after('harga');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('propertis') && Schema::hasColumn('propertis', 'units_available')) {
            Schema::table('propertis', function (Blueprint $table) {
                $table->dropColumn('units_available');
            });
        }
    }
};

