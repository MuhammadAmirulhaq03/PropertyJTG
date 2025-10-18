<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;

class ContractorController extends Controller
{
    public function create()
    {
        return view('components.contractor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'alamat' => 'required',
        ]);

        Contractor::create($request->all());

        return redirect()->back()->with('success', 'Booking berhasil dikirim!');
    }
}

