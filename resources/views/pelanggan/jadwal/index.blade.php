<x-app-layout>
    <section class="bg-[#FFF5EE] min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
                <aside class="bg-white rounded-3xl shadow-md border border-[#FFDCC4] overflow-hidden">
                    <div class="bg-[#DB4437] text-white px-6 py-6">
                        <p class="text-xs uppercase tracking-widest font-semibold">Customer Journey</p>
                        <p class="text-xl font-bold mt-1">Jadwal Kunjungan</p>
                        <p class="text-sm opacity-80 mt-3">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <nav class="px-5 py-6 space-y-2 text-sm text-gray-600">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-2xl hover:bg-[#FFF2E9] transition">
                            <span class="w-2 h-2 bg-[#DB4437]/60 rounded-full"></span>
                            {{ __('Customer Dashboard') }}
                        </a>
                        <a href="{{ route('homepage') }}" class="flex items-center gap-3 px-3 py-2 rounded-2xl hover:bg-[#FFF2E9] transition">
                            <span class="w-2 h-2 bg-[#DB4437]/60 rounded-full"></span>
                            {{ __('Home Page') }}
                        </a>
                        <span class="flex items-center gap-3 px-3 py-2 rounded-2xl bg-[#FFF2E9] text-[#DB4437] font-medium">
                            <span class="w-2 h-2 bg-[#DB4437] rounded-full"></span>
                            {{ __('Jadwal Kunjungan') }}
                        </span>
                        <span class="flex items-center gap-3 px-3 py-2 rounded-2xl text-gray-300 cursor-not-allowed">
                            <span class="w-2 h-2 bg-gray-200 rounded-full"></span>
                            Favorite (coming soon)
                        </span>
                    </nav>
                </aside>

                <div class="flex flex-col gap-8">
                    <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] px-6 py-8 sm:px-10 sm:py-12">
                        <header class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <h1 class="text-3xl font-bold text-[#DB4437]">Atur Jadwal Konsultasi</h1>
                                <p class="mt-2 text-gray-600 text-sm sm:text-base">
                                    Pilih waktu terbaik Anda untuk berkonsultasi dengan tim kami. Kami akan mengonfirmasi ketersediaan dan menghubungi Anda.
                                </p>
                            </div>
                            <div class="bg-[#FFF2E9] rounded-2xl px-4 py-3 text-xs sm:text-sm text-[#DB4437] font-medium shadow-sm">
                                {{ __('Permintaan jadwal akan diproses dalam 1 hari kerja.') }}
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

                        <form method="POST" action="{{ route('pelanggan.jadwal.store') }}" class="mt-8 space-y-6">
                            @csrf
                            <div class="grid gap-6 md:grid-cols-2">
                                <label class="space-y-2">
                                    <span class="block text-sm font-semibold text-gray-700">Nama Konsultan</span>
                                    <input type="text" name="nama_konsultan" value="{{ old('nama_konsultan') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" required>
                                </label>
                                <label class="space-y-2">
                                    <span class="block text-sm font-semibold text-gray-700">Tanggal</span>
                                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" required>
                                </label>
                            </div>

                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Waktu</span>
                                <input type="time" name="waktu" value="{{ old('waktu') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3" required>
                            </label>

                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Catatan Tambahan</span>
                                <textarea name="catatan" rows="4" class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm" placeholder="Beritahu kami topik atau kebutuhan khusus untuk pertemuan">{{ old('catatan') }}</textarea>
                            </label>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <p class="text-xs text-gray-400">Kami akan menghubungi Anda melalui email atau telepon untuk konfirmasi.</p>
                                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-[#DB4437] text-white text-sm font-semibold hover:bg-[#c63c31] transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h12m0 0l-4-4m4 4l-4 4m9 4V7a2 2 0 00-2-2h-7" />
                                    </svg>
                                    Kirim Permintaan
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] px-6 py-8 sm:px-10 sm:py-10">
                        <h2 class="text-2xl font-semibold text-[#DB4437]">Jadwal Konsultasi Anda</h2>
                        <p class="mt-2 text-sm text-gray-600">Lihat dan kelola jadwal yang telah Anda ajukan.</p>

                        <div class="mt-6 space-y-4">
                            @forelse ($schedules as $schedule)
                                <div class="border border-[#FFE7D6] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold text-[#DB4437]">{{ $schedule->nama_konsultan }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('l, d F Y') }}
                                            • {{ \Carbon\Carbon::parse($schedule->waktu)->format('H:i') }} WIB
                                        </p>
                                        @if ($schedule->catatan)
                                            <p class="text-sm text-gray-500">{{ $schedule->catatan }}</p>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('pelanggan.jadwal.destroy', $schedule) }}" class="self-start sm:self-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-600 text-sm font-semibold hover:bg-red-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="text-center py-10 border border-dashed border-[#FFE7D6] rounded-3xl text-sm text-gray-500">
                                    {{ __('Belum ada jadwal konsultasi. Silakan buat jadwal baru.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
