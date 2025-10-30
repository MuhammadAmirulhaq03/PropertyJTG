<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Customer;
use App\Models\Properti;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    /**
     * Display the feedback form for the authenticated customer.
     */
    public function create(Request $request): View
    {
        $properties = Properti::query()
            ->orderBy('nama')
            ->get();

        return view('pelanggan.feedback.create', [
            'properties' => $properties,
            'user' => $request->user(),
        ]);
    }

    /**
     * Store a new feedback entry submitted by the customer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'properti_id' => ['required', 'exists:propertis,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'mood' => ['nullable', 'integer', 'in:1,2,3'],
            'komentar' => ['nullable', 'string', 'max:1000'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = $request->user();
        $property = Properti::findOrFail($validated['properti_id']);

        // Ensure we always reference a valid customers.id (FK). Create a minimal
        // Customer record for this user if it doesn't exist yet.
        $customerId = optional($user->customer)->id
            ?? Customer::firstOrCreate(['user_id' => $user->id])->id;

        Feedback::create([
            'properti_id' => $property->id,
            'admin_id' => $property->admin_id,
            'customer_id' => $customerId,
            'rating' => $validated['rating'],
            'mood' => $validated['mood'] ?? null,
            'komentar' => $validated['komentar'] ?? $validated['message'],
            'message' => $validated['message'] ?? $validated['komentar'],
            'tanggal' => now()->toDateString(),
        ]);

        return redirect()
            ->route('pelanggan.feedback.create')
            ->with('success', __('Terima kasih atas feedback yang Anda berikan!'));
    }
}
