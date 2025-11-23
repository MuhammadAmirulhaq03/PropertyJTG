<x-app-layout>
    <section class="bg-[#FFF5EE] min-h-screen pt-[4.5rem] pb-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
                <aside class="bg-white rounded-3xl shadow-md border border-[#FFDCC4] overflow-hidden">
                    <div class="bg-[#DB4437] text-white px-6 py-6">
                        <p class="text-xs uppercase tracking-widest font-semibold">Customer Journey</p>
                        <p class="text-xl font-bold mt-1">Bagikan Feedback</p>
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
                                [
                                    'label' => __('Favorit'),
                                    'route' => route('pelanggan.favorit.index'),
                                    'active' => request()->routeIs('pelanggan.favorit.*'),
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
                    </nav>
                </aside>

                <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] px-6 py-8 sm:px-10 sm:py-12">
                    <header class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-[#DB4437]">Ceritakan Pengalaman Anda</h1>
                            <p class="mt-2 text-gray-600 text-sm sm:text-base">
                                Kami ingin mendengar bagaimana perjalanan Anda bersama Jaya Tibar Group. Feedback Anda membantu kami meningkatkan layanan.
                            </p>
                        </div>
                        <div class="bg-[#FFF2E9] rounded-2xl px-4 py-3 text-xs sm:text-sm text-[#DB4437] font-medium shadow-sm">
                            {{ __('Feedback dikirimkan ke admin properti terkait.') }}
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

                    <form method="POST" action="{{ route('pelanggan.feedback.store') }}" class="mt-8 space-y-8">
                        @csrf

                        <div class="grid gap-6 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Pilih Properti</span>
                                <select
                                    name="properti_id"
                                    class="block w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm py-3"
                                    required
                                >
                                    <option value="" disabled selected>-- Pilih properti --</option>
                                    @foreach ($properties as $property)
                                        <option value="{{ $property->id }}" @selected(old('properti_id') == $property->id)>
                                            {{ $property->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Nilai pengalaman Anda</span>
                                <div class="flex items-center gap-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="rating-option flex flex-col items-center justify-center w-12 h-12 rounded-2xl border text-sm font-semibold cursor-pointer transition transform {{ old('rating') == $i ? 'bg-[#DB4437] text-white border-[#DB4437] ring-2 ring-[#DB4437] ring-offset-2 ring-offset-white shadow-sm scale-105' : 'border-[#F4D3C5] hover:border-[#DB4437]' }}">
                                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only" {{ old('rating') == $i ? 'checked' : '' }} required>
                                            {{ $i }}
                                        </label>
                                    @endfor
                                </div>
                            </label>
                        </div>

                        <div>
                            <span class="block text-sm font-semibold text-gray-700 mb-3">Bagaimana perasaan Anda?</span>
                            <div class="flex items-center gap-6">
                                @php
                                    $moods = [
                                        1 => 'Kurang puas',
                                        2 => 'Cukup puas',
                                        3 => 'Sangat puas',
                                    ];
                                    $icons = [1 => '😞', 2 => '😐', 3 => '😊'];
                                @endphp
                                @foreach ($moods as $value => $label)
                                    <label class="mood-option flex flex-col items-center gap-2 cursor-pointer rounded-2xl px-3 py-2 transition {{ old('mood') == $value ? 'bg-[#DB4437]/10 ring-2 ring-[#DB4437] ring-offset-2 ring-offset-white' : 'hover:bg-[#FFF2E9]' }}">
                                        <span class="text-3xl">{{ $icons[$value] }}</span>
                                        <input type="radio" name="mood" value="{{ $value }}" class="hidden" {{ old('mood') == $value ? 'checked' : '' }}>
                                        <span class="text-xs font-medium text-gray-600">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Ceritakan pengalaman Anda</span>
                                <textarea
                                    name="message"
                                    rows="4"
                                    class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm"
                                    placeholder="Apa yang membuat Anda senang atau perlu kami tingkatkan?"
                                >{{ old('message') }}</textarea>
                            </label>

                            <label class="space-y-2">
                                <span class="block text-sm font-semibold text-gray-700">Pesan untuk tim kami (opsional)</span>
                                <textarea
                                    name="komentar"
                                    rows="4"
                                    class="w-full rounded-2xl border-gray-200 focus:border-[#DB4437] focus:ring-[#DB4437] text-sm"
                                    placeholder="Tambahkan detail lain yang perlu diketahui tim kami."
                                >{{ old('komentar') }}</textarea>
                            </label>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <p class="text-xs text-gray-400">Dengan mengirimkan feedback, Anda mengizinkan tim kami menghubungi jika diperlukan klarifikasi.</p>
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-[#DB4437] text-white text-sm font-semibold hover:bg-[#c63c31] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h12m0 0l-4-4m4 4l-4 4m9 4V7a2 2 0 00-2-2h-7" />
                                </svg>
                                Kirim Feedback
                            </button>
                        </div>
                    </form>

                    <script>
                        (function () {
                            // Rating selection visual state
                            const ratingOptions = Array.from(document.querySelectorAll('.rating-option'));
                            const ratingInputs = Array.from(document.querySelectorAll('input[name="rating"]'));
                            function setRatingVisual(val) {
                                ratingOptions.forEach((label, idx) => {
                                    const selected = (idx + 1) === Number(val);
                                    label.classList.toggle('bg-\[\#DB4437\]', selected);
                                    label.classList.toggle('text-white', selected);
                                    label.classList.toggle('border-\[\#DB4437\]', selected);
                                    label.classList.toggle('ring-2', selected);
                                    label.classList.toggle('ring-\[\#DB4437\]', selected);
                                    label.classList.toggle('ring-offset-2', selected);
                                    label.classList.toggle('ring-offset-white', selected);
                                    label.classList.toggle('shadow-sm', selected);
                                    label.classList.toggle('scale-105', selected);
                                });
                            }
                            ratingInputs.forEach((input) => {
                                input.addEventListener('change', () => setRatingVisual(input.value));
                            });
                            const checkedRating = document.querySelector('input[name="rating"]:checked');
                            if (checkedRating) setRatingVisual(checkedRating.value);

                            // Mood selection visual state
                            const moodOptions = Array.from(document.querySelectorAll('.mood-option'));
                            const moodInputs = Array.from(document.querySelectorAll('input[name="mood"]'));
                            function setMoodVisual(val) {
                                moodOptions.forEach((label, idx) => {
                                    const selected = (idx + 1) === Number(val);
                                    label.classList.toggle('bg-\[\#DB4437\]/10', selected);
                                    label.classList.toggle('ring-2', selected);
                                    label.classList.toggle('ring-\[\#DB4437\]', selected);
                                    label.classList.toggle('ring-offset-2', selected);
                                    label.classList.toggle('ring-offset-white', selected);
                                });
                            }
                            moodInputs.forEach((input) => {
                                input.addEventListener('change', () => setMoodVisual(input.value));
                            });
                            const checkedMood = document.querySelector('input[name="mood"]:checked');
                            if (checkedMood) setMoodVisual(checkedMood.value);
                        })();
                    </script>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
