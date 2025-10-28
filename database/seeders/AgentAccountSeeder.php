<?php

namespace Database\Seeders;

use App\Models\Agen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentAccountSeeder extends Seeder
{
    /**
     * Create an additional agent account (idempotent by email).
     */
    public function run(): void
    {
        $email = 'agent2@jtg.local';

        $user = User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Agent Two',
                'password' => Hash::make('password'),
                'role' => 'agen',
                'phone' => '0895401550972',
                'email_verified_at' => now(),
            ]
        );

        // Ensure the agent profile exists and is linked correctly
        Agen::query()->firstOrCreate([
            'user_id' => $user->id,
        ]);
    }
}

