<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KprCalculatorController extends Controller
{
    /**
     * Display the calculator page for authenticated customers.
     */
    public function show(Request $request): View
    {
        $properties = $this->availableProperties();
        $selectedProperty = $properties->firstWhere('id', (int) $request->input('property_id'));

        return view('pelanggan.kpr.index', [
            'properties' => $properties,
            'selectedPropertyId' => optional($selectedProperty)['id'],
            'selectedProperty' => $selectedProperty,
        ]);
    }

    /**
     * Process the mortgage calculation.
     */
    public function calculate(Request $request): View
    {
        $request->merge([
            'harga_properti' => str_replace(['.', ','], '', (string) $request->input('harga_properti', '')),
            'pendapatan_bulanan' => str_replace(['.', ','], '', (string) $request->input('pendapatan_bulanan', '')),
            'uang_muka_nominal' => str_replace(['.', ','], '', (string) $request->input('uang_muka_nominal', '')),
            'persentase_dp' => str_replace(',', '.', (string) $request->input('persentase_dp', '')),
        ]);

        $validated = $request->validate([
            'harga_properti' => ['required', 'numeric', 'min:1'],
            'persentase_dp' => ['required', 'numeric', 'min:0', 'max:100'],
            'uang_muka_nominal' => ['nullable', 'numeric', 'min:0'],
            'jangka_waktu' => ['required', 'integer', 'min:1'],
            'suku_bunga' => ['required', 'numeric', 'min:0'],
            'pendapatan_bulanan' => ['required', 'numeric', 'min:0'],
            'property_id' => ['nullable', 'integer'],
        ], [
            'harga_properti.min' => __('Harga properti harus lebih dari 0.'),
            'persentase_dp.min' => __('Persentase DP tidak boleh negatif.'),
            'persentase_dp.max' => __('Persentase DP tidak boleh lebih dari 100%.'),
            'jangka_waktu.min' => __('Jangka waktu minimal 1 tahun.'),
            'suku_bunga.min' => __('Suku bunga tidak boleh negatif.'),
            'pendapatan_bulanan.min' => __('Pendapatan bulanan tidak boleh negatif.'),
        ]);

        $properties = $this->availableProperties();
        $selectedProperty = $properties->firstWhere('id', (int) $request->input('property_id'));

        $hargaProperti = $selectedProperty['price'] ?? (float) $validated['harga_properti'];
        $persentaseDP = (float) $validated['persentase_dp'];
        $uangMukaNominal = (float) ($validated['uang_muka_nominal'] ?? 0);
        $jangkaWaktuTahun = (int) $validated['jangka_waktu'];
        $sukuBungaTahunan = (float) $validated['suku_bunga'];
        $pendapatanBulanan = (float) $validated['pendapatan_bulanan'];

        if ($uangMukaNominal > $hargaProperti) {
            return back()
                ->withErrors(['uang_muka_nominal' => __('Uang muka tidak boleh melebihi harga properti.')])
                ->withInput();
        }

        if ($uangMukaNominal > 0 && $hargaProperti > 0) {
            $persentaseDP = max(min(($uangMukaNominal / $hargaProperti) * 100, 100), 0);
        }

        $uangMuka = $hargaProperti * ($persentaseDP / 100);
        $pokokPinjaman = max($hargaProperti - $uangMuka, 0);
        $sukuBungaBulanan = ($sukuBungaTahunan / 100) / 12;
        $jumlahBulan = max($jangkaWaktuTahun * 12, 1);

        $cicilanBulanan = 0.0;
        if ($pokokPinjaman > 0) {
            if ($sukuBungaBulanan > 0) {
                $pembilang = $sukuBungaBulanan * pow(1 + $sukuBungaBulanan, $jumlahBulan);
                $penyebut = pow(1 + $sukuBungaBulanan, $jumlahBulan) - 1;
                $cicilanBulanan = $penyebut > 0 ? $pokokPinjaman * ($pembilang / $penyebut) : $pokokPinjaman / $jumlahBulan;
            } else {
                $cicilanBulanan = $pokokPinjaman / $jumlahBulan;
            }
        }

        $totalPembayaran = $cicilanBulanan * $jumlahBulan;
        $totalBunga = max($totalPembayaran - $pokokPinjaman, 0);

        $rasioUtangPersen = $pendapatanBulanan > 0 ? ($cicilanBulanan / $pendapatanBulanan) * 100 : 0;
        $statusKelayakan = match (true) {
            $pokokPinjaman <= 0 => __('Tidak Memerlukan Cicilan'),
            $pendapatanBulanan <= 0 && $cicilanBulanan > 0 => __('Pendapatan tidak valid'),
            $rasioUtangPersen <= 30 => __('Sehat - Layak'),
            $rasioUtangPersen <= 40 => __('Hati-hati - Beresiko Sedang'),
            default => __('Tidak Sehat - Beresiko Tinggi'),
        };

        $hasil = [
            'harga_properti' => round($hargaProperti, 0),
            'uang_muka' => round($uangMuka, 0),
            'pokok_pinjaman' => round($pokokPinjaman, 0),
            'tenor' => $jangkaWaktuTahun,
            'suku_bunga' => $sukuBungaTahunan,
            'cicilan_bulanan' => round($cicilanBulanan, 0),
            'total_bayar' => round($totalPembayaran, 0),
            'total_bunga' => round($totalBunga, 0),
            'pendapatan_bulanan' => round($pendapatanBulanan, 0),
            'rasio_utang' => round($rasioUtangPersen, 1),
            'status_kelayakan' => $statusKelayakan,
        ];

        return view('pelanggan.kpr.index', [
            'properties' => $properties,
            'selectedPropertyId' => $selectedProperty['id'] ?? null,
            'selectedProperty' => $selectedProperty,
            'hasil' => $hasil,
        ])->withInput($request->all());
    }

    /**
     * Retrieve available properties for simulation.
     *
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function availableProperties()
    {
        return collect(config('properties', []))
            ->map(fn ($property) => [
                'id' => $property['id'],
                'title' => $property['title'],
                'location' => $property['location'] ?? '',
                'price' => (int) ($property['price'] ?? 0),
                'image' => $property['image'] ?? null,
            ])
            ->values();
    }
}
