<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class UserRolesTest extends TestCase
{
    public function test_has_role_with_single_and_multiple(): void
    {
        $user = User::factory()->make(['role' => 'agen']);
        $this->assertTrue($user->hasRole('agen'));
        $this->assertFalse($user->hasRole('admin'));
        $this->assertTrue($user->hasRole(['customer', 'agen']));
    }

    public function test_has_permission_direct_wildcard_and_inherits(): void
    {
        // Direct permission for agen
        $agen = User::factory()->make(['role' => 'agen']);
        $this->assertTrue($agen->hasPermission('manage-documents'));

        // Admin wildcard
        $admin = User::factory()->make(['role' => 'admin']);
        $this->assertTrue($admin->hasPermission('any-ability-at-all'));

        // Inherit from customer: remove direct permission then rely on inherits
        Config::set('roles.permissions.agen', ['manage-properties']); // remove view-dashboard here
        Config::set('roles.inherits.agen', ['customer']);
        Config::set('roles.permissions.customer', ['view-dashboard']);

        $agen2 = User::factory()->make(['role' => 'agen']);
        $this->assertTrue($agen2->hasPermission('view-dashboard'));
    }
}