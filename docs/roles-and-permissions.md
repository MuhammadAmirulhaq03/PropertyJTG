## Access Control Overview

This project uses a lightweight role → permission matrix stored in `config/roles.php` and backed by the `users.role` column (values: `admin`, `agen`, `customer`). The matrix drives both backend authorisation gates and Blade UI visibility.

### Roles and Capabilities

| Role       | Description                       | Permissions                                                                 |
| ---------- | --------------------------------- | --------------------------------------------------------------------------- |
| `admin`    | Full platform control             | `*` (inherits every ability, including the agent + customer sets)           |
| `agen`     | Internal sales / agent workspace  | `view-dashboard`, `manage-properties`, `manage-documents`, `manage-schedule`, `view-team-metrics`, `access-shortcuts` |
| `customer` | Read-only self-service experience | `view-dashboard`                                                            |

Inheritance is defined in the same config file, so admins inherit agent permissions and agents inherit customer permissions.

### Gate Registration

`App\Providers\AppServiceProvider::boot()` reads the matrix and registers Laravel Gates for every declared permission. A `Gate::before` hook automatically authorises roles with the `*` wildcard. Adding a new ability only requires updating `config/roles.php`; no extra code changes are needed.

### Using Permissions in Code

- **Routes / Controllers** – apply middleware such as `->middleware('can:manage-documents')` to protect actions.
- **Blade Templates** – wrap components with `@can('manage-properties')`, `@cannot`, or `@canany` so users only see what they are allowed to use.
- **User Helpers** – the `User` model exposes `roleSlug()`, `hasRole()`, and `hasPermission()` helpers for ad-hoc checks.

### Authentication Flows

- Customers register/sign in through `/register` and `/login`. If a non-customer uses the public login, they are asked to switch to the staff portal.
- Agents and administrators authenticate via `/staff/login`, which enforces the `admin` / `agen` roles before establishing a session.
- After login, `DashboardController` routes each role to its own dashboard view (`dashboards.customer` for customers, `dashboards.agent` for agents and admins with extras for administrators).

### Assigning Roles

Roles live on the `users` table. You can set them when creating users (the public registration flow automatically assigns `customer`) or update existing records:

```bash
php artisan tinker
>>> App\Models\User::whereEmail('ivander@example.com')->update(['role' => 'agen']);
```

If no role is present, the system falls back to the configured default (`customer`).

### Extending the Matrix

1. Add the new permission to the relevant role(s) inside `config/roles.php`.
2. Optionally update `config/roles.php['inherits']` if the ability should cascade.
3. Reference the ability anywhere via `Gate`, `@can`, or route middleware.
4. Document UI changes so the team understands which roles can access the new functionality.

Because permissions are centrally defined, you can review and evolve the entire access policy from a single configuration file.

