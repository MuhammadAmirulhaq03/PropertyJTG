<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
            // Track real-time presence; ensure Carbon instance
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Display name with role-based prefix for agents.
     */
    protected function displayName(): Attribute
    {
        return Attribute::get(function () {
            $name = $this->attributes['name'] ?? '';
            if ($this->roleSlug() === 'agen') {
                $lower = \Illuminate\Support\Str::lower($name);
                if (\Illuminate\Support\Str::startsWith($lower, 'agent ')) {
                    return $name;
                }
                return 'Agent ' . $name;
            }
            return $name;
        });
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function agen()
    {
        // Correct foreign key mapping: agents table references users via user_id
        return $this->hasOne(Agen::class, 'user_id');
    }

    public function customer()
    {
        // Correct foreign key mapping: customers table references users via user_id
        return $this->hasOne(Customer::class, 'user_id');
    }

    public function searchHistories(): HasMany
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function propertyFavorites(): HasMany
    {
        return $this->hasMany(PropertyFavorite::class);
    }

    public function favoriteProperties(): BelongsToMany
    {
        return $this->belongsToMany(Properti::class, 'property_favorites', 'user_id', 'properti_id')
            ->withTimestamps();
    }
}
