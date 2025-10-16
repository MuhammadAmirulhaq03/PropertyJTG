<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $permissions = config('roles.permissions', []);

        $abilities = [];
        foreach ($permissions as $abilityList) {
            foreach ($abilityList as $ability) {
                if ($ability !== '*') {
                    $abilities[$ability] = true;
                }
            }
        }

        Gate::before(function ($user, string $ability) use ($permissions) {
            $role = $user->role ?? config('roles.default');

            if ($this->roleCan($role, '*', $permissions)) {
                return true;
            }

            return null;
        });

        foreach (array_keys($abilities) as $ability) {
            Gate::define($ability, function ($user) use ($ability, $permissions) {
                $role = $user->role ?? config('roles.default');

                return $this->roleCan($role, $ability, $permissions);
            });
        }
    }

    /**
     * Determine if the supplied role grants the ability.
     */
    protected function roleCan(string $role, string $ability, array $permissions, array $visited = []): bool
    {
        if (in_array($role, $visited, true)) {
            return false;
        }

        $rolePermissions = $permissions[$role] ?? [];

        if (in_array('*', $rolePermissions, true)) {
            return true;
        }

        if ($ability !== '*' && in_array($ability, $rolePermissions, true)) {
            return true;
        }

        $visited[] = $role;

        $inherits = config("roles.inherits.$role", []);
        foreach ($inherits as $parentRole) {
            if ($this->roleCan($parentRole, $ability, $permissions, $visited)) {
                return true;
            }
        }

        return false;
    }
}
