<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Resolve the role slug for the authenticated user.
     */
    public function roleSlug(): string
    {
        return $this->role ?? config('roles.default', 'customer');
    }

    /**
     * Determine if the user owns the supplied role(s).
     *
     * @param  string|array<int, string>  $roles
     */
    public function hasRole(string|array $roles): bool
    {
        $roles = (array) $roles;

        return in_array($this->roleSlug(), $roles, true);
    }

    /**
     * Retrieve the permissions granted to the user's role.
     *
     * @return array<int, string>
     */
    public function permissions(): array
    {
        $role = $this->roleSlug();
        $permissions = config('roles.permissions', []);

        return $permissions[$role] ?? [];
    }

    /**
     * Check if the user may perform the provided ability.
     */
    public function hasPermission(string $ability): bool
    {
        if (Gate::forUser($this)->check($ability)) {
            return true;
        }

        $permissions = $this->permissions();
        if (in_array('*', $permissions, true)) {
            return true;
        }

        if (in_array($ability, $permissions, true)) {
            return true;
        }

        $inherits = config('roles.inherits.' . $this->roleSlug(), []);
        foreach ($inherits as $role) {
            $rolePermissions = config('roles.permissions.' . $role, []);
            if (in_array('*', $rolePermissions, true) || in_array($ability, $rolePermissions, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'alamat',
        'foto_profil',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function agen()
    {
        return $this->hasOne(Agen::class, 'id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id');
    }

    public function searchHistories(): HasMany
    {
        return $this->hasMany(SearchHistory::class);
    }
}
