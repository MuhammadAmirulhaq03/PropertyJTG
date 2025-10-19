<x-app-layout>
    <section class="bg-[#FFF5EE] min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
                <aside class="bg-white rounded-3xl shadow-md border border-[#FFDCC4] overflow-hidden">
                    <div class="bg-[#DB4437] text-white px-6 py-6">
                        <p class="text-xs uppercase tracking-widest font-semibold">Customer Journey</p>
                        <p class="text-xl font-bold mt-1">Pemesanan Kontraktor</p>
                        <p class="text-sm opacity-80 mt-3">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <nav class="px-5 py-6 space-y-2 text-sm text-gray-600">
                        @php
                            $customerLinks = [
                                [
                                    'label' => __('Customer Dashboard'),
                                    'route' => route('dashboard'),
                                    'active' => request()->routeIs('dashboard'),
                                ],
                                [
                                    'label' => __('Home Page'),
                                    'route' => route('homepage'),
                                    'active' => request()->routeIs('homepage'),
                                ],
                                [
                                    'label' => __('Document'),
                                    'route' => route('documents.index'),
                                    'active' => request()->routeIs('documents.*'),
                                ],
                                [
                                    'label' => __('Feedback'),
                                    'route' => route('pelanggan.feedback.create'),
                                    'active' => request()->routeIs('pelanggan.feedback.*'),
                                ],
                                [
                                    'label' => __('Konsultan Properti'),
                                    'route' => route('pelanggan.consultants.create'),
                                    'active' => request()->routeIs('pelanggan.consultants.*'),
                                ],
                                [
                                    'label' => __('Pemesanan Kontraktor'),
                                    'route' => route('pelanggan.contractors.create'),
                                    'active' => request()->routeIs('pelanggan.contractors.*'),
                                ],
                                [
                                    'label' => __('Jadwal Kunjungan'),
                                    'route' => route('pelanggan.jadwal.index'),
                                    'active' => request()->routeIs('pelanggan.jadwal.*'),
                                ],
                                [
                                    'label' => __('Kalkulator KPR'),
                                    'route' => route('pelanggan.kpr.show'),
                                    'active' => request()->routeIs('pelanggan.kpr.*'),
                                ],
                            ];
                        @endphp

                        @foreach ($customerLinks as $item)
                            <a
                                href="{{ $item['route'] }}"
                                class="flex items-center gap-3 px-3 py-2 rounded-2xl transition {{ $item['active'] ? 'bg-[#DB4437]/10 text-[#DB4437] font-semibold shadow-sm' : 'text-gray-600 hover:bg-[#FFF2E9]' }}"
                            >
                                <span class="w-2 h-2 rounded-full {{ $item['active'] ? 'bg-[#DB4437]' : 'bg-[#DB4437]/60' }}"></span>
                                {{ $item['label'] }}
                            </a>
                        @endforeach

                        <span class="flex items-center gap-3 px-3 py-2 rounded-2xl text-gray-300 cursor-not-allowed">
                            <span class="w-2 h-2 bg-gray-200 rounded-full"></span>
                            Favorite (coming soon)
                        </span>
                    </nav>
                </aside>

                <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] px-6 py-8 sm:px-10 sm:py-12">
                    <header class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-[#DB4437]">Mulai Proyek Anda</h1>
                            <p class="mt-2 text-gray-600 text-sm sm:text-base">
                                Isi detail proyek konstruksi yang Anda butuhkan. Tim kontraktor kami akan menghubungi untuk konsultasi lebih lanjut.
                            </p>
                        </div>
                        <div class="bg-[#FFF2E9] rounded-2xl px-4 py-3 text-xs sm:text-sm text-[#DB4437] font-medium shadow-sm">
                            {{ __('Estimasi respon dalam 1-2 hari kerja.') }}
                        </div>
                    </header>

                    @if (session('success'))
                        <div class="mt-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-4 py-3 text-sm font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 bg-red-50 border border-red-200 text-red-600 rounded-2xl px-4 py-3 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pelanggan.contractors.store') }}" class="mt-8 space-y-8">
                        @csrf

                        <div class="grid gap-6 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Nama Lengkap</span>
                                <input type="text" name="nama" value="{{ old('nama', auth()->user()->name ?? '') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" required>
                            </label>
                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Email</span>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" required>
                            </label>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Nomor Telepon</span>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" required>
                            </label>
                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Luas Bangunan / Lahan</span>
                                <input type="text" name="luas_bangunan_lahan" value="{{ old('luas_bangunan_lahan') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" placeholder="Contoh: 120 m²">
                            </label>
                        </div>

                        <label class="space-y-2">
                            <span class="block text-sm font-semibold text-gray-700">Alamat / Titik Lokasi</span>
                            <input type="text" name="alamat" value="{{ old('alamat', auth()->user()->alamat ?? '') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" required>
                        </label>

                        <label class="space-y-2">
                            <span class="block text-sm font-semibold text-gray-700">Detail Lokasi Tambahan</span>
                            <input type="text" name="titik_lokasi" value="{{ old('titik_lokasi') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" placeholder="Contoh: Dekat stasiun, akses kendaraan besar">
                        </label>

                        <label class="space-y-2">
                            <span class="block text-sm font-semibold text-gray-700">Pesan Singkat (opsional)</span>
                            <textarea name="pesan" rows="4" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm" placeholder="Jelaskan kebutuhan proyek secara singkat">{{ old('pesan') }}</textarea>
                        </label>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <p class="text-xs text-gray-400">Data Anda hanya digunakan untuk penjadwalan konsultasi kontraktor.</p>
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-[#DB4437] text-white text-sm font-semibold hover:bg-[#c63c31] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h12m0 0l-4-4m4 4l-4 4m9 4V7a2 2 0 00-2-2h-7" />
                                </svg>
                                Kirim Permintaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
