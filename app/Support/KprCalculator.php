<?php

namespace App\Support;

class KprCalculator
{
    /**
     * Calculate KPR figures based on inputs. Returns an array mirroring the
     * values produced in KprCalculatorController for consistency.
     *
     * @return array{
     *   harga_properti:int, uang_muka:int, pokok_pinjaman:int, tenor:int,
     *   suku_bunga:float, cicilan_bulanan:int, total_bayar:int, total_bunga:int,
     *   pendapatan_bulanan:int, rasio_utang:float, status_kelayakan:string
     * }
     */
    public function calculate(
        float $hargaProperti,
        float $persentaseDP,
        float $uangMukaNominal,
        int $jangkaWaktuTahun,
        float $sukuBungaTahunan,
        float $pendapatanBulanan
    ): array {
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
            $pokokPinjaman <= 0 => 'Tidak Memerlukan Cicilan',
            $pendapatanBulanan <= 0 && $cicilanBulanan > 0 => 'Pendapatan tidak valid',
            $rasioUtangPersen <= 30 => 'Sehat - Layak',
            $rasioUtangPersen <= 40 => 'Hati-hati - Beresiko Sedang',
            default => 'Tidak Sehat - Beresiko Tinggi',
        };

        return [
            'harga_properti' => (int) round($hargaProperti, 0),
            'uang_muka' => (int) round($uangMuka, 0),
            'pokok_pinjaman' => (int) round($pokokPinjaman, 0),
            'tenor' => $jangkaWaktuTahun,
            'suku_bunga' => $sukuBungaTahunan,
            'cicilan_bulanan' => (int) round($cicilanBulanan, 0),
            'total_bayar' => (int) round($totalPembayaran, 0),
            'total_bunga' => (int) round($totalBunga, 0),
            'pendapatan_bulanan' => (int) round($pendapatanBulanan, 0),
            'rasio_utang' => round($rasioUtangPersen, 1),
            'status_kelayakan' => $statusKelayakan,
        ];
    }
}
