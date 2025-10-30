<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed demo staff accounts for quick testing (idempotent)
        $this->call([
            \Database\Seeders\AgentAccountSeeder::class,
            \Database\Seeders\AdminAccountSeeder::class,
        ]);
    }
}
