<?php

namespace Tests\Feature\Pelanggan;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Pelanggan\ProfileController;
use PHPUnit\Framework\Attributes\Test;

class ProfileControllerUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Route khusus untuk pengujian
        Route::patch('/__test/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/__test/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    }

    #[Test]
    public function update_mengubah_data_dan_mereset_verifikasi_email_jika_email_berubah(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $payload = [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ];

        $response = $this->patch(route('profile.update'), $payload);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $user->refresh();
        $this->assertSame('New Name', $user->name);
        $this->assertSame('new@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    #[Test]
    public function update_tidak_mereset_verifikasi_email_jika_email_tidak_berubah(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'same@example.com',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $payload = [
            'name' => 'Renamed',
            'email' => 'same@example.com',
        ];

        $response = $this->patch(route('profile.update'), $payload);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $user->refresh();
        $this->assertSame('Renamed', $user->name);
        $this->assertSame('same@example.com', $user->email);
        $this->assertNotNull($user->email_verified_at);
    }
}
