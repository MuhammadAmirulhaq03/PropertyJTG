<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultantController extends Controller
{
    /**
     * Display the consultant request form.
     */
    public function create(): View
    {
        return view('pelanggan.consultants.create');
    }

    /**
     * Persist the consultant request submitted by a customer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'alamat' => ['required', 'string', 'max:500'],
            'spesialisasi' => ['nullable', 'string', 'max:255'],
        ]);

        Consultant::create($validated);

        return redirect()
            ->route('pelanggan.consultants.create')
            ->with('success', __('Permintaan konsultasi telah dikirim. Tim kami akan menghubungi Anda.'));
    }
}
