<x-app-layout>
        {{-- Area Konten Kalkulator --}}
        <div class="flex-1 p-6 lg:p-10 bg-gray-50 dark:bg-gray-900">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-3xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold text-[#DB4437] mb-6">Kalkulator KPR</h1>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">

                        {{-- KOLOM KIRI: FORM INPUT (Lebih lebar) --}}
                        <div class="md:col-span-3">
                            <form method="POST" action="{{ route('kpr.calculator.calculate') }}" class="space-y-6">
                                @csrf

                                {{-- Baris Input Harga Properti & Persentase DP --}}
                                    <div>
                                        <x-input-label for="harga_properti" :value="__('Harga Properti (Rp)')" class="mb-1" />
                                        <x-text-input id="harga_properti" class="block w-full bg-gray-50" type="text" name="harga_properti" :value="old('harga_properti')" required autofocus />
                                        <x-input-error :messages="$errors->get('harga_properti')" class="mt-2" />
                                    </div>
                                     <div>
                                        <x-input-label for="persentase_dp" :value="__('Persentase Uang Muka (%)')" class="mb-1" />
                                        <x-text-input id="persentase_dp" class="block w-full bg-gray-50" type="number" name="persentase_dp" :value="old('persentase_dp')" required min="0" max="100" />
                                        <x-input-error :messages="$errors->get('persentase_dp')" class="mt-2" />
                                    </div>

                                 {{-- Baris Input Jangka Waktu & Suku Bunga --}}
                                    <div>
                                        <x-input-label for="jangka_waktu" :value="__('Jangka Waktu (Tahun)')" class="mb-1" />
                                        <x-text-input id="jangka_waktu" class="block w-full bg-gray-50" type="number" name="jangka_waktu" :value="old('jangka_waktu')" required min="1" />
                                        <x-input-error :messages="$errors->get('jangka_waktu')" class="mt-2" />
                                    </div>
                                     <div>
                                        <x-input-label for="suku_bunga" :value="__('Suku Bunga (% per Tahun)')" class="mb-1"/>
                                        <x-text-input id="suku_bunga" class="block w-full bg-gray-50" type="number" step="0.01" name="suku_bunga" :value="old('suku_bunga')" required min="0" />
                                        <x-input-error :messages="$errors->get('suku_bunga')" class="mt-2" />
                                    </div>

                                 {{-- Input Pendapatan Bulanan --}}
                                 <div>
                                    <x-input-label for="pendapatan_bulanan" :value="__('Pendapatan Bulanan (Rp)')" class="mb-1" />
                                    <x-text-input id="pendapatan_bulanan" class="block w-full bg-gray-50" type="text" name="pendapatan_bulanan" :value="old('pendapatan_bulanan')" required min="0" />
                                    <x-input-error :messages="$errors->get('pendapatan_bulanan')" class="mt-2" />
                                 </div>

                                {{-- Tombol Hitung --}}
                                <div class="pt-2">
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-8 py-3 bg-[#DB4437] border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-[#c63c31] focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                                        {{ __('Hitung KPR') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- KOLOM KANAN: HASIL KALKULASI (Lebih sempit) --}}
                        <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700 p-6 rounded-2xl border border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6 border-b pb-3">Hasil Kalkulasi</h3>

                            @isset($hasil)
                                <div class="space-y-5">
                                    {{-- Rincian Input --}}
                                    <div class="text-sm space-y-2">
                                         <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Harga Properti:</span>
                                            <span class="font-medium">Rp {{ number_format($hasil['harga_properti'], 0, ',', '.') }}</span>
                                        </div>
                                         <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Uang Muka:</span>
                                            <span class="font-medium">Rp {{ number_format($hasil['uang_muka'], 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Pokok Pinjaman:</span>
                                            <span class="font-medium">Rp {{ number_format($hasil['pokok_pinjaman'], 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Tenor:</span>
                                            <span class="font-medium">{{ $hasil['tenor'] }} Tahun</span>
                                        </div>
                                        {{-- <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Skema Bunga:</span>
                                            <span class="font-medium">{{ $hasil['skema_bunga'] }}</span>
                                        </div> --}}
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Suku Bunga:</span>
                                            <span class="font-medium">{{ number_format($hasil['suku_bunga'], 1, ',', '.') }}% per tahun</span>
                                        </div>
                                    </div>

                                    <hr class="dark:border-gray-600">

                                    {{-- Hasil Cicilan --}}
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cicilan per Bulan:</p>
                                        <p class="text-4xl font-bold text-[#DB4437] mt-1">
                                            Rp {{ number_format($hasil['cicilan_bulanan'], 0, ',', '.') }}
                                        </p>
                                    </div>

                                     <div class="text-sm space-y-2 pt-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Total Bayar:</span>
                                            <span class="font-medium">Rp {{ number_format($hasil['total_bayar'], 0, ',', '.') }}</span>
                                        </div>
                                         <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Total Bunga:</span>
                                            <span class="font-medium">Rp {{ number_format($hasil['total_bunga'], 0, ',', '.') }}</span>
                                        </div>
                                     </div>

                                    <hr class="dark:border-gray-600">

                                    {{-- Analisis Kelayakan --}}
                                    <div>
                                        <h4 class="font-semibold mb-2 text-gray-800 dark:text-gray-200">Analisis Kelayakan:</h4>
                                        <div class="text-sm space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Pendapatan Bulanan:</span>
                                                <span class="font-medium">Rp {{ number_format($hasil['pendapatan_bulanan'], 0, ',', '.') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Rasio Utang:</span>
                                                <span class="font-medium">{{ $hasil['rasio_utang'] }}%</span>
                                            </div>
                                             <div class="flex justify-between items-center pt-1">
                                                <span class="text-gray-600 dark:text-gray-400">Status Kelayakan:</span>
                                                <span @class([
                                                    'px-2 py-0.5 rounded-full text-xs font-semibold',
                                                    'bg-emerald-100 text-emerald-800' => str_contains($hasil['status_kelayakan'], 'Sehat'),
                                                    'bg-amber-100 text-amber-800' => str_contains($hasil['status_kelayakan'], 'Hati-hati'),
                                                    'bg-red-100 text-red-800' => str_contains($hasil['status_kelayakan'], 'Tidak Sehat'),
                                                    'bg-gray-100 text-gray-800' => !str_contains($hasil['status_kelayakan'], 'Sehat') && !str_contains($hasil['status_kelayakan'], 'Hati-hati') && !str_contains($hasil['status_kelayakan'], 'Tidak Sehat'),
                                                ])>
                                                    {{ $hasil['status_kelayakan'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                     {{-- Panduan Rasio Utang --}}
                                    <div class="mt-4 bg-blue-50 dark:bg-blue-900/50 p-4 rounded-lg border border-blue-200 dark:border-blue-800 text-xs text-blue-800 dark:text-blue-200 space-y-1">
                                        <h5 class="font-semibold mb-1">Panduan Rasio Utang:</h5>
                                        <p><strong class="font-medium">&le; 30%</strong> : Sehat - Layak untuk KPR</p>
                                        <p><strong class="font-medium">31-40%</strong> : Hati-hati - Beresiko sedang</p>
                                        <p><strong class="font-medium">&gt; 40%</strong> : Tidak sehat - Beresiko tinggi</p>
                                    </div>

                                </div>
                            @else
                                {{-- Tampilan default jika belum ada hasil --}}
                                <p class="text-gray-500 dark:text-gray-400 text-center py-10">
                                    Masukkan detail pinjaman Anda untuk melihat estimasi cicilan dan analisis kelayakan.
                                </p>
                            @endisset
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- JavaScript untuk format Rupiah--}}
<script>
    function formatRupiah(element) {
        let value = element.value;
        // 1. Hapus semua karakter kecuali angka
        let number_string = value.replace(/[^,\d]/g, '').toString();

        // 2. Hapus titik pemisah ribuan yang sudah ada (jika ada)
        number_string = number_string.replace(/\./g, '');

        // 3. Format ulang dengan titik
        let split = number_string.split(','); // (jaga jika ada desimal, walau di sini tidak)
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // 4. Tambahkan titik jika ada ribuan
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        // 5. Gabungkan kembali
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        // 6. Set nilai input
        element.value = rupiah;
    }

    // Ambil elemen input
    const hargaPropertiInput = document.getElementById('harga_properti');
    const pendapatanBulananInput = document.getElementById('pendapatan_bulanan');

    // Tambahkan event listener 'input' (lebih baik dari 'keyup' karena menangani paste)
    hargaPropertiInput.addEventListener('input', function(e) {
        formatRupiah(this);
    });

    pendapatanBulananInput.addEventListener('input', function(e) {
        formatRupiah(this);
    });

    // Format juga nilai 'old' saat halaman dimuat (jika ada error validasi)
    document.addEventListener('DOMContentLoaded', function() {
        if (hargaPropertiInput.value) {
            formatRupiah(hargaPropertiInput);
        }
        if (pendapatanBulananInput.value) {
            formatRupiah(pendapatanBulananInput);
        }
    });
</script>
</x-app-layout>