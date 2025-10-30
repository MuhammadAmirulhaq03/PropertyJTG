<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agen;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;
use Throwable;

class StaffController extends Controller
{
    public function index(Request $request): View
    {
        $agents = User::query()->where('role', 'agen')->orderBy('name')->get();

        return view('admin.staff.agents', [
            'agents' => $agents,
        ]);
    }

    public function storeAgent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique(User::class, 'email'),
                function ($attr, $value, $fail) {
                    if (! Str::endsWith(Str::lower($value), '@gmail.com')) {
                        $fail(__('Email harus menggunakan domain gmail.com.'));
                    }
                },
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => Str::lower($validated['email']),
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => 'agen',
                'email_verified_at' => now(),
            ]);

            // Force change on first login
            $user->forceFill(['must_change_password' => true, 'remember_token' => Str::random(60)])->save();

            Agen::firstOrCreate(['user_id' => $user->id]);
        });

        return back()->with('success', __('Akun agen berhasil dibuat.'));
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'agen', 404);

        $validated = $request->validate([
            'new_password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        DB::transaction(function () use ($user, $validated) {
            $user->forceFill([
                'password' => Hash::make($validated['new_password']),
                'must_change_password' => true,
                'remember_token' => Str::random(60),
            ])->save();

            DB::table('sessions')->where('user_id', $user->id)->delete();
        });

        return back()->with('success', __('Kata sandi sementara telah diset. Agen harus menggantinya saat login.'));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'agen', 404);

        try {
            DB::transaction(function () use ($user) {
                // Terminate any active sessions for this user
                DB::table('sessions')->where('user_id', $user->id)->delete();
                // Deleting the user will cascade to agens and related FKs that are set to cascade
                $user->delete();
            });
        } catch (Throwable $e) {
            return back()->with('error', __('Tidak dapat menghapus agen karena terkait data lain.'))->with('error_detail', $e->getMessage());
        }

        return back()->with('success', __('Agen berhasil dihapus.'));
    }
}
