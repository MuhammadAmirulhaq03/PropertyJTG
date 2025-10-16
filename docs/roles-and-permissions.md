## Access Control Overview

This project now uses a lightweight role → permission matrix that is stored in `config/roles.php` and backed by the existing `users.role` column (values: `admin`, `agen`, `customer`). The matrix drives both backend authorisation gates and Blade UI visibility.

### Roles and Capabilities

| Role        | Description                                 | Permissions                                                                 |
| ----------- | ------------------------------------------- | --------------------------------------------------------------------------- |
| `admin`     | Full platform control                       | `*` (all permissions inherit every ability, including agent + customer set) |
| `agen`      | Property/agent workspace                    | `view-dashboard`, `manage-properties`, `manage-documents`, `manage-schedule`, `view-team-metrics`, `access-shortcuts` |
| `customer`  | Read-only / self-service experience         | `view-dashboard`                                                            |

Inheritance is defined in the same config file, so admins inherit agent permissions and agents inherit customer permissions.

### Gate Registration

`App\Providers\AppServiceProvider::boot()` reads the matrix and registers Laravel Gates for every declared permission. A `Gate::before` hook automatically authorises roles with the `*` wildcard. Adding a new ability only requires updating `config/roles.php`; no extra code changes are needed.

### Using Permissions in Code

- **Routes / Controllers** – apply middleware such as `->middleware('can:manage-documents')` to protect actions.
- **Blade Templates** – wrap components with `@can('manage-properties')`, `@cannot`, or `@canany` so users only see what they’re allowed to use.
- **User Helpers** – the `User` model exposes `roleSlug()`, `hasRole()`, and `hasPermission()` helpers for ad-hoc checks.

### Assigning Roles

Roles continue to live on the `users` table. You can set them when creating users or update existing rows:

```bash
php artisan tinker
>>> App\Models\User::whereEmail('ivander@example.com')->update(['role' => 'agen']);
```

If no role is present, the system falls back to the configured default (`customer`).

### Extending the Matrix

1. Add the new permission to the relevant role(s) inside `config/roles.php`.
2. Optionally update `config/roles.php['inherits']` if the ability should cascade.
3. Reference the ability anywhere in your code via `Gate`, `@can`, or route middleware.
4. Document UI changes so the team understands which roles can access the new functionality.

Because permissions are centrally defined, you can review the entire access policy through a single configuration file, keeping future updates straightforward.

