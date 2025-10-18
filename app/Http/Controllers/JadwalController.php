<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function tampil()
    {
        $daftarJadwal = Jadwal::all();
        return view('jadwal', compact('daftarJadwal'));
    }

    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'nama_konsultan' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'catatan' => 'nullable|string',
        ]);

        Jadwal::create($validated);
        return redirect()->route('tampil.jadwal')->with('success', 'Jadwal berhasil disimpan!');
    }

    public function hapus($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->route('tampil.jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}

