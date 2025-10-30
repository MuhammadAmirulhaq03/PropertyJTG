<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Create an additional admin account (idempotent by email).
     */
    public function run(): void
    {
        $email = 'admin2@jtg.local';

        $user = User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Two',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '087821752151',
                'email_verified_at' => now(),
            ]
        );

        // Ensure the admin profile exists and is linked correctly
        Admin::query()->firstOrCreate([
            'user_id' => $user->id,
        ]);
    }
}

