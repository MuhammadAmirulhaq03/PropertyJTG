<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Agen;
use App\Models\Admin;
use App\Models\Customer;

class UserObserver
{
    public function created(User $user): void
    {
        switch ($user->role) {
            case 'agen':
                Agen::create([
                    'user_id' => $user->id,
                ]);
                break;

            case 'admin':
                Admin::create([
                    'user_id' => $user->id,
                ]);
                break;

            case 'customer':
                Customer::create([
                    'user_id' => $user->id,
                ]);
                break;
        }
    }
}

