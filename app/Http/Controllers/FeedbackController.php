<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('components.feedback');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mood' => 'required|in:1,2,3',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:1000',
        ]);

        Feedback::create($validated);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
