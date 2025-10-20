<?php

namespace Tests\Unit;

use App\Support\KprCalculator;
use Tests\TestCase;

class KprCalculatorTest extends TestCase
{
    public function test_zero_interest_monthly_equals_principal_over_tenor(): void
    {
        $svc = new KprCalculator();
        $result = $svc->calculate(
            hargaProperti: 600_000_000,
            persentaseDP: 20,
            uangMukaNominal: 0,
            jangkaWaktuTahun: 20,
            sukuBungaTahunan: 0,
            pendapatanBulanan: 10_000_000,
        );

        // 600m * (1 - 20%) = 480m; tenor 20y -> 240 months; 480m / 240 = 2m
        $this->assertSame(2_000_000, $result['cicilan_bulanan']);
    }

    public function test_with_interest_matches_formula_within_small_delta(): void
    {
        $svc = new KprCalculator();
        $price = 600_000_000; $dpPct = 20; $tenorY = 20; $rateY = 10;
        $principal = $price * (1 - $dpPct / 100);
        $r = ($rateY / 100) / 12; $n = $tenorY * 12;
        $expected = ($principal > 0 && $r > 0)
            ? $principal * (($r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1))
            : 0.0;

        $result = $svc->calculate($price, $dpPct, 0, $tenorY, $rateY, 100_000_000);

        $this->assertEqualsWithDelta((int) round($expected, 0), $result['cicilan_bulanan'], 2);
    }

    public function test_dp_nominal_overrides_percentage(): void
    {
        $svc = new KprCalculator();
        $price = 500_000_000; $dpNom = 300_000_000; $dpPct = 10; // should ignore 10%
        $result = $svc->calculate($price, $dpPct, $dpNom, 10, 0, 30_000_000);

        $this->assertSame(300_000_000, $result['uang_muka']);
        $this->assertSame(200_000_000, $result['pokok_pinjaman']);
    }

    public function test_dp_greater_than_price_means_no_installment_needed(): void
    {
        $svc = new KprCalculator();
        $result = $svc->calculate(100_000_000, 0, 200_000_000, 10, 0, 10_000_000);

        $this->assertSame(0, $result['pokok_pinjaman']);
        $this->assertSame('Tidak Memerlukan Cicilan', $result['status_kelayakan']);
        $this->assertSame(0, $result['cicilan_bulanan']);
    }

    public function test_debt_ratio_thresholds(): void
    {
        $svc = new KprCalculator();
        // Choose numbers for easy monthly = 2,000,000 (zero interest, principal 240m over 10y)
        $price = 240_000_000; $dpPct = 0; $tenorY = 10; $rateY = 0;
        $monthly = 2_000_000;

        // 30%
        $r30 = $svc->calculate($price, $dpPct, 0, $tenorY, $rateY, $monthly / 0.30);
        $this->assertSame('Sehat - Layak', $r30['status_kelayakan']);

        // 35%
        $r35 = $svc->calculate($price, $dpPct, 0, $tenorY, $rateY, $monthly / 0.35);
        $this->assertSame('Hati-hati - Beresiko Sedang', $r35['status_kelayakan']);

        // >40%
        $r50 = $svc->calculate($price, $dpPct, 0, $tenorY, $rateY, 4_000_000);
        $this->assertSame('Tidak Sehat - Beresiko Tinggi', $r50['status_kelayakan']);
    }
}