<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractorController extends Controller
{
    /**
     * Display the contractor booking form.
     */
    public function create(): View
    {
        return view('pelanggan.contractors.create');
    }

    /**
     * Store a contractor booking submitted by a customer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'alamat' => ['required', 'string', 'max:500'],
            'luas_bangunan_lahan' => ['nullable', 'string', 'max:255'],
            'titik_lokasi' => ['nullable', 'string', 'max:255'],
            'pesan' => ['nullable', 'string', 'max:1000'],
        ]);

        Contractor::create($validated);

        return redirect()
            ->route('pelanggan.contractors.create')
            ->with('success', __('Permintaan jasa kontraktor telah diterima. Tim kami akan menghubungi Anda.'));
    }
}
