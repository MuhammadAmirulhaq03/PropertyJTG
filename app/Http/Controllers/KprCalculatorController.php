<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class KprCalculatorController extends Controller
{
/**
     * Memproses perhitungan KPR yang lebih lengkap.
     */
    public function show(): View
    {
        // Hanya menampilkan view, 'hasil' akan null/tidak ada
        return view('kpr-calculator');
    }
    /**
     * Memproses perhitungan KPR sesuai use case (tanpa skema bunga kompleks).
     */
    public function calculate(Request $request)
    {
        // Bersihkan format titik dari input sebelum validasi
        $request->merge([
            'harga_properti' => str_replace('.', '', $request->input('harga_properti')),
            'pendapatan_bulanan' => str_replace('.', '', $request->input('pendapatan_bulanan')),
        ]);
        
        // 1. Validasi input sesuai use case description
        $validated = $request->validate([
            'harga_properti' => 'required|numeric|min:1',
            'persentase_dp' => 'required|numeric|min:0|max:100', // Use case pakai DP, kita hitung persentasenya
            'jangka_waktu' => 'required|integer|min:1', // Tenor dalam tahun
            'suku_bunga' => 'required|numeric|min:0', // Bunga tetap
            'pendapatan_bulanan' => 'required|numeric|min:0',
        ], [
            // Pesan error custom jika diperlukan
            'harga_properti.min' => 'Harga properti harus lebih dari 0.',
            'persentase_dp.min' => 'Persentase DP tidak boleh negatif.',
            'persentase_dp.max' => 'Persentase DP tidak boleh lebih dari 100%.',
            'jangka_waktu.min' => 'Jangka waktu minimal 1 tahun.',
            'suku_bunga.min' => 'Suku bunga tidak boleh negatif.',
            'pendapatan_bulanan.min' => 'Pendapatan bulanan tidak boleh negatif.',
        ]);

        // 2. Ambil nilai input
        $hargaProperti = (float) $validated['harga_properti'];
        $persentaseDP = (float) $validated['persentase_dp'];
        $jangkaWaktuTahun = (int) $validated['jangka_waktu'];
        $sukuBungaTahunan = (float) $validated['suku_bunga'];
        $pendapatanBulanan = (float) $validated['pendapatan_bulanan'];

        // 3. Lakukan logika perhitungan KPR dasar
        $uangMuka = $hargaProperti * ($persentaseDP / 100);
        $pokokPinjaman = $hargaProperti - $uangMuka;
        $sukuBungaBulanan = ($sukuBungaTahunan / 100) / 12;
        $jumlahBulan = $jangkaWaktuTahun * 12; // Jumlah total bulan tenor

        $cicilanBulanan = 0;
        if ($pokokPinjaman > 0 && $jumlahBulan > 0) {
             if ($sukuBungaBulanan > 0) {
                // Rumus Anuitas: M = P [ i(1+i)^n ] / [ (1+i)^n – 1]
                $pembilang = $sukuBungaBulanan * pow(1 + $sukuBungaBulanan, $jumlahBulan);
                $penyebut = pow(1 + $sukuBungaBulanan, $jumlahBulan) - 1;
                // Hindari pembagian dengan nol jika penyebut = 0 (misal bunga sangat tinggi & tenor pendek)
                $cicilanBulanan = ($penyebut > 0) ? ($pokokPinjaman * ($pembilang / $penyebut)) : $pokokPinjaman;
            } else {
                // Jika bunga 0%
                $cicilanBulanan = $pokokPinjaman / $jumlahBulan;
            }
        } else if ($pokokPinjaman == 0) {
             $cicilanBulanan = 0; // Jika DP 100%
        }


        $totalPembayaran = $cicilanBulanan * $jumlahBulan;
        $totalBunga = $totalPembayaran - $pokokPinjaman;

        // 4. Analisis Kelayakan berdasarkan Rasio Utang (Debt-to-Income Ratio / DTI)
        $rasioUtangPersen = ($pendapatanBulanan > 0) ? ($cicilanBulanan / $pendapatanBulanan) * 100 : 0;
        $statusKelayakan = 'Tidak Diketahui';
        if ($rasioUtangPersen <= 0 && $cicilanBulanan > 0) {
            $statusKelayakan = 'Pendapatan tidak valid';
        } else if ($rasioUtangPersen <= 30) {
            $statusKelayakan = 'Sehat - Layak';
        } elseif ($rasioUtangPersen <= 40) {
            $statusKelayakan = 'Hati-hati - Beresiko Sedang';
        } else {
            $statusKelayakan = 'Tidak Sehat - Beresiko Tinggi';
        }
        // Khusus jika cicilan 0 (DP 100% atau harga 0)
        if ($cicilanBulanan <= 0 && $pokokPinjaman <= 0) {
             $rasioUtangPersen = 0;
             $statusKelayakan = 'Tidak Memerlukan Cicilan';
        }


        // 5. Siapkan data hasil untuk dikirim ke view (sesuai desain)
        $hasil = [
            'harga_properti' => round($hargaProperti, 0),
            'uang_muka' => round($uangMuka, 0),
            'pokok_pinjaman' => round($pokokPinjaman, 0),
            'tenor' => $jangkaWaktuTahun, // Tahun
            // 'skema_bunga' => 'Fixed Rate', // Dihardcode karena skema dikecualikan
            'suku_bunga' => $sukuBungaTahunan, // Persen per tahun
            'cicilan_bulanan' => round($cicilanBulanan, 0),
            'total_bayar' => round($totalPembayaran, 0),
            'total_bunga' => round($totalBunga, 0),
            'pendapatan_bulanan' => round($pendapatanBulanan, 0),
            'rasio_utang' => round($rasioUtangPersen, 1), // Persen, 1 desimal
            'status_kelayakan' => $statusKelayakan,
        ];

        // 6. Kembalikan ke view
        return view('kpr-calculator', [
            'hasil' => $hasil
        ])->withInput($request->all());
    }
}
