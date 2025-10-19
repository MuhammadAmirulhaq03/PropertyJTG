<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman register.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses register user baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            // ✅ Validasi email: format benar, unik, dan bukan @example.com
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    if (str_ends_with($value, '@example.com')) {
                        $fail('Pendaftaran dengan email @example.com tidak diperbolehkan.');
                    }
                },
            ],

            // ✅ Validasi phone: wajib, minimal 12 digit, hanya angka
            'phone' => [
                'required',
                'digits_between:12,15', // minimal 12 digit, maksimal 15
                'regex:/^[0-9]+$/', // hanya boleh angka
            ],

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            // Pesan error custom biar lebih jelas
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.digits_between' => 'Nomor telepon minimal 12 digit dan maksimal 15 digit.',
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
        ]);

        // ✅ Simpan data user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => config('roles.default', 'user'),
        ]);

        event(new Registered($user));

        // 🚫 Tidak langsung login — diarahkan ke halaman login
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
