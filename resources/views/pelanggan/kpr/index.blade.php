<x-app-layout>
    <section class="min-h-screen bg-[#FFF5E9] py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-lg border border-[#FFDCC4] overflow-hidden">
                <div class="bg-[#DB4437] text-white px-6 py-8">
                    <p class="text-xs uppercase tracking-widest font-semibold">Customer Journey</p>
                    <h1 class="text-3xl font-bold mt-2">Kalkulator KPR</h1>
                    <p class="text-sm opacity-80 mt-3">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>

                @php
                    $properties = $properties ?? collect();
                    $selectedPropertyId = old('property_id', $selectedPropertyId ?? null);
                    $selectedProperty = $selectedProperty ?? $properties->firstWhere('id', (int) $selectedPropertyId);
                @endphp

                <div class="px-6 py-8 sm:px-10 sm:py-12 space-y-10">
                    <form method="POST" action="{{ route('pelanggan.kpr.calculate') }}" class="grid gap-6">
                        @csrf

                        <div>
                            <x-input-label for="property_id" :value="__('Pilih Properti dari Listing')" />
                            <select
                                id="property_id"
                                name="property_id"
                                class="mt-1 block w-full rounded-2xl border border-[#FFE7D6] bg-gray-50 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm"
                            >
                                <option value="">{{ __('-- Pilih properti (opsional) --') }}</option>
                                @foreach ($properties as $property)
                                    <option
                                        value="{{ $property['id'] }}"
                                        data-price="{{ $property['price'] }}"
                                        data-image="{{ $property['image'] }}"
                                        data-title="{{ $property['title'] }}"
                                        data-location="{{ $property['location'] }}"
                                        {{ (string) $selectedPropertyId === (string) $property['id'] ? 'selected' : '' }}
                                    >
                                        {{ $property['title'] }} — Rp {{ number_format($property['price'], 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="harga_properti" :value="__('Harga Properti (Rp)')" />
                            <x-text-input id="harga_properti" class="mt-1 block w-full bg-gray-50" type="text" name="harga_properti" :value="old('harga_properti', optional($selectedProperty)['price'] ? number_format($selectedProperty['price'], 0, ',', '.') : null)" required />
                            <x-input-error :messages="$errors->get('harga_properti')" class="mt-2" />
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="persentase_dp" :value="__('Persentase Uang Muka (%)')" />
                                <x-text-input id="persentase_dp" class="mt-1 block w-full bg-gray-50" type="number" name="persentase_dp" :value="old('persentase_dp')" min="0" max="100" step="0.01" required />
                                <x-input-error :messages="$errors->get('persentase_dp')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="uang_muka_nominal" :value="__('Nominal Uang Muka (Rp)')" />
                                <x-text-input id="uang_muka_nominal" class="mt-1 block w-full bg-gray-50" type="text" name="uang_muka_nominal" :value="old('uang_muka_nominal')" />
                                <x-input-error :messages="$errors->get('uang_muka_nominal')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-3">
                            <div>
                                <x-input-label for="jangka_waktu" :value="__('Jangka Waktu (Tahun)')" />
                                <x-text-input id="jangka_waktu" class="mt-1 block w-full bg-gray-50" type="number" name="jangka_waktu" :value="old('jangka_waktu')" min="1" required />
                                <x-input-error :messages="$errors->get('jangka_waktu')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="suku_bunga" :value="__('Suku Bunga (% per Tahun)')" />
                                <x-text-input id="suku_bunga" class="mt-1 block w-full bg-gray-50" type="number" step="0.01" name="suku_bunga" :value="old('suku_bunga')" min="0" required />
                                <x-input-error :messages="$errors->get('suku_bunga')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pendapatan_bulanan" :value="__('Pendapatan Bulanan (Rp)')" />
                                <x-text-input id="pendapatan_bulanan" class="mt-1 block w-full bg-gray-50" type="text" name="pendapatan_bulanan" :value="old('pendapatan_bulanan')" min="0" required />
                                <x-input-error :messages="$errors->get('pendapatan_bulanan')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-[#DB4437] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#c63c31]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2" />
                                </svg>
                                {{ __('Hitung Cicilan KPR') }}
                            </button>
                        </div>
                    </form>

                    <div class="bg-[#FFF8F3] border border-[#FFE7D6] rounded-3xl p-6 space-y-6">
                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="sm:w-48">
                                <div class="aspect-[4/3] w-full rounded-2xl bg-gray-200 overflow-hidden">
                                    <img
                                        id="property-preview-image"
                                        src="{{ optional($selectedProperty)['image'] }}"
                                        alt="{{ optional($selectedProperty)['title'] }}"
                                        class="h-full w-full object-cover {{ $selectedProperty ? '' : 'hidden' }}"
                                    >
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold text-[#DB4437]" id="property-preview-title">
                                    {{ optional($selectedProperty)['title'] ?? __('Belum memilih properti') }}
                                </h2>
                                <p class="text-sm text-gray-500 mt-1" id="property-preview-location">
                                    {{ optional($selectedProperty)['location'] ?? __('Pilih properti untuk mengisi harga secara otomatis atau masukkan manual.') }}
                                </p>
                            </div>
                        </div>

                        <hr class="border-[#FFE7D6]">

                        <h2 class="text-lg font-semibold text-[#DB4437]">Ringkasan Simulasi</h2>

                        @isset($hasil)
                            <div class="grid gap-4 sm:grid-cols-2 mt-4">
                                <div class="space-y-2 text-sm">
                                    @if($selectedProperty)
                                        <div>
                                            <span class="text-gray-600 block">Properti</span>
                                            <span class="font-semibold">{{ $selectedProperty['title'] }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between"><span class="text-gray-600">Harga Properti</span><span class="font-semibold">Rp {{ number_format($hasil['harga_properti'], 0, ',', '.') }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Uang Muka</span><span class="font-semibold">Rp {{ number_format($hasil['uang_muka'], 0, ',', '.') }} ({{ number_format(($hasil['uang_muka'] / max($hasil['harga_properti'], 1)) * 100, 2, ',', '.') }}%)</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Pokok Pinjaman</span><span class="font-semibold">Rp {{ number_format($hasil['pokok_pinjaman'], 0, ',', '.') }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Tenor</span><span class="font-semibold">{{ $hasil['tenor'] }} Tahun</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Suku Bunga</span><span class="font-semibold">{{ number_format($hasil['suku_bunga'], 2, ',', '.') }}% p.a</span></div>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex flex-col rounded-2xl bg-white border border-[#FFE7D6] p-5 text-center">
                                        <span class="text-sm text-gray-500">Cicilan per Bulan</span>
                                        <span class="text-3xl font-bold text-[#DB4437] mt-1">Rp {{ number_format($hasil['cicilan_bulanan'], 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-gray-600">Total Pembayaran</span><span class="font-semibold">Rp {{ number_format($hasil['total_bayar'], 0, ',', '.') }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Total Bunga</span><span class="font-semibold">Rp {{ number_format($hasil['total_bunga'], 0, ',', '.') }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Rasio Utang</span><span class="font-semibold">{{ $hasil['rasio_utang'] }}%</span></div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Status Kelayakan</span>
                                        <span @class([
                                            'px-3 py-1 rounded-full text-xs font-semibold',
                                            'bg-emerald-100 text-emerald-800' => str_contains($hasil['status_kelayakan'], 'Sehat'),
                                            'bg-amber-100 text-amber-800' => str_contains($hasil['status_kelayakan'], 'Hati-hati'),
                                            'bg-red-100 text-red-800' => str_contains($hasil['status_kelayakan'], 'Tidak Sehat'),
                                            'bg-gray-100 text-gray-800' => ! str_contains($hasil['status_kelayakan'], 'Sehat') && ! str_contains($hasil['status_kelayakan'], 'Hati-hati') && ! str_contains($hasil['status_kelayakan'], 'Tidak Sehat'),
                                        ])>
                                            {{ $hasil['status_kelayakan'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">
                                Masukkan detail pinjaman di atas untuk melihat simulasi cicilan dan status kelayakan KPR.
                            </p>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const properties = @json($properties->values());

            const formatRupiah = (element) => {
                const raw = element.value.replace(/[^\d]/g, '');
                if (! raw) {
                    element.value = '';
                    return 0;
                }
                const reversed = raw.split('').reverse().join('');
                const chunks = reversed.match(/.{1,3}/g) ?? [];
                const formatted = chunks.join('.').split('').reverse().join('');
                element.value = formatted;
                return parseInt(raw, 10) || 0;
            };

            const unformat = (value) => parseInt((value || '').toString().replace(/[^\d]/g, ''), 10) || 0;

            const propertySelect = document.getElementById('property_id');
            const hargaInput = document.getElementById('harga_properti');
            const pendapatanInput = document.getElementById('pendapatan_bulanan');
            const dpPercentInput = document.getElementById('persentase_dp');
            const dpAmountInput = document.getElementById('uang_muka_nominal');
            const previewTitle = document.getElementById('property-preview-title');
            const previewLocation = document.getElementById('property-preview-location');
            const previewImage = document.getElementById('property-preview-image');

            let syncing = false;

            const syncAmountFromPercent = () => {
                if (syncing) return;
                syncing = true;
                const harga = unformat(hargaInput.value);
                const percent = parseFloat(dpPercentInput.value || '0');
                const amount = Math.round((harga * percent) / 100);
                if (dpAmountInput) {
                    dpAmountInput.value = amount ? amount.toLocaleString('id-ID') : '';
                }
                syncing = false;
            };

            const syncPercentFromAmount = () => {
                if (syncing) return;
                syncing = true;
                const harga = unformat(hargaInput.value);
                const amount = unformat(dpAmountInput.value);
                const percent = harga > 0 ? Math.min((amount / harga) * 100, 100) : 0;
                dpPercentInput.value = percent ? percent.toFixed(2).replace(/\.0+$/, '') : '';
                syncing = false;
            };

            [hargaInput, pendapatanInput, dpAmountInput].forEach((input) => {
                if (! input) {
                    return;
                }
                input.addEventListener('input', () => {
                    formatRupiah(input);
                    if (input === hargaInput) {
                        syncAmountFromPercent();
                    }
                    if (input === dpAmountInput) {
                        syncPercentFromAmount();
                    }
                });
                if (input.value) {
                    formatRupiah(input);
                }
            });

            if (dpPercentInput) {
                dpPercentInput.addEventListener('input', syncAmountFromPercent);
            }

            const updatePreview = (property) => {
                if (!property) {
                    previewTitle.textContent = '{{ __('Belum memilih properti') }}';
                    previewLocation.textContent = '{{ __('Pilih properti untuk mengisi harga secara otomatis atau masukkan manual.') }}';
                    if (previewImage) {
                        previewImage.classList.add('hidden');
                        previewImage.removeAttribute('src');
                        previewImage.removeAttribute('alt');
                    }
                    return;
                }

                previewTitle.textContent = property.title;
                previewLocation.textContent = property.location || '';
                if (previewImage && property.image) {
                    previewImage.src = property.image;
                    previewImage.alt = property.title;
                    previewImage.classList.remove('hidden');
                }
            };

            const handlePropertyChange = () => {
                const selectedId = parseInt(propertySelect.value, 10);
                const property = properties.find((item) => item.id === selectedId);

                if (property) {
                    if (dpPercentInput && !dpPercentInput.value) {
                        dpPercentInput.value = '20';
                    }
                    hargaInput.value = property.price.toLocaleString('id-ID');
                    formatRupiah(hargaInput);
                    syncAmountFromPercent();
                }

                updatePreview(property);
            };

            if (propertySelect) {
                propertySelect.addEventListener('change', handlePropertyChange);
                handlePropertyChange();
            }

            syncAmountFromPercent();
            if (dpAmountInput && dpAmountInput.value) {
                syncPercentFromAmount();
            }
        });
    </script>
</x-app-layout>
