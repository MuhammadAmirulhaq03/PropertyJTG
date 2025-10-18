<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultant;

class ConsultantController extends Controller
{
    public function create()
    {
        return view('components.consultant');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'alamat' => 'required',
            'spesialisasi' => 'nullable',
        ]);

        Consultant::create($request->all());

        return redirect()->back()->with('success', 'Data consultant berhasil dikirim!');
    }
}
