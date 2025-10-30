<x-admin.customer.layout selected-tab="visit-schedules">
    <div class="max-w-3xl space-y-8">
        <a href="{{ route('admin.visit-schedules.index', ['tab' => 'visit-schedules']) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#2563EB] hover:text-[#1E3A8A]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
            </svg>
            {{ __('Kembali ke daftar jadwal') }}
        </a>

        <div class="space-y-6 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <header>
                <h1 class="text-xl font-semibold text-gray-900">{{ __('Ubah Jadwal Kunjungan') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Sesuaikan jadwal agen, catatan, dan ketersediaan slot kunjungan.') }}</p>
            </header>

            <form method="POST" action="{{ route('admin.visit-schedules.update', $schedule) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="agent_id" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Pilih agen') }}</label>
                    <select id="agent_id" name="agent_id" required class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB] {{ $schedule->isBooked() ? 'cursor-not-allowed opacity-70' : '' }}" {{ $schedule->isBooked() ? 'disabled' : '' }}>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" @selected(old('agent_id', $schedule->agent_id) == $agent->id)>{{ $agent->display_name }} — {{ $agent->email }}</option>
                        @endforeach
                    </select>
                    @if($schedule->isBooked())
                        <input type="hidden" name="agent_id" value="{{ $schedule->agent_id }}">
                        <p class="mt-1 text-xs text-amber-600">{{ __('Agen tidak dapat diubah karena jadwal sudah dibooking pelanggan.') }}</p>
                    @endif
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="date" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Tanggal') }}</label>
                        <input type="date" id="date" name="date" value="{{ old('date', $schedule->start_at->toDateString()) }}" min="{{ now()->toDateString() }}" required class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB] {{ $schedule->isBooked() ? 'cursor-not-allowed opacity-70' : '' }}" {{ $schedule->isBooked() ? 'disabled' : '' }}>
                        @if($schedule->isBooked())
                            <input type="hidden" name="date" value="{{ $schedule->start_at->toDateString() }}">
                        @endif
                    </div>
                    <div>
                        <label for="location" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Lokasi') }}</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $schedule->location) }}" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="start_time" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Waktu Mulai') }}</label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $schedule->start_at->format('H:i')) }}" required class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB] {{ $schedule->isBooked() ? 'cursor-not-allowed opacity-70' : '' }}" {{ $schedule->isBooked() ? 'disabled' : '' }}>
                        @if($schedule->isBooked())
                            <input type="hidden" name="start_time" value="{{ $schedule->start_at->format('H:i') }}">
                        @endif
                    </div>
                    <div>
                        <label for="end_time" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Waktu Selesai') }}</label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $schedule->end_at->format('H:i')) }}" required class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB] {{ $schedule->isBooked() ? 'cursor-not-allowed opacity-70' : '' }}" {{ $schedule->isBooked() ? 'disabled' : '' }}>
                        @if($schedule->isBooked())
                            <input type="hidden" name="end_time" value="{{ $schedule->end_at->format('H:i') }}">
                        @endif
                    </div>
                </div>

                <div>
                    <label for="notes" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Catatan') }}</label>
                    <textarea id="notes" name="notes" rows="3" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">{{ old('notes', $schedule->notes) }}</textarea>
                </div>

                @if(! $schedule->isBooked())
                    <div>
                        <label for="status" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Status Jadwal') }}</label>
                        <select id="status" name="status" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            <option value="available" @selected(old('status', $schedule->status) === 'available')>{{ __('Tersedia') }}</option>
                            <option value="closed" @selected(old('status', $schedule->status) === 'closed')>{{ __('Ditutup') }}</option>
                        </select>
                    </div>
                @endif

                <div class="flex items-center justify-between gap-4">
                    <p class="text-xs text-gray-500">{{ __('Jeda minimal 25 menit antar jadwal agen dan maksimal 3 agen per slot waktu.') }}</p>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-[#2563EB] px-5 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14" />
                        </svg>
                        {{ __('Simpan Perubahan') }}
                    </button>
                </div>
            </form>

            @if ($schedule->isBooked())
                <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-700">
                    {{ __('Jadwal ini sedang dibooking oleh pelanggan, sehingga perubahan agen, tanggal, atau jam tidak diperbolehkan.') }}
                </div>
            @endif
        </div>
    </div>
</x-admin.customer.layout>

<script>
(function(){
    const dateEl = document.getElementById('date');
    const startEl = document.getElementById('start_time');
    const endEl = document.getElementById('end_time');
    if(!dateEl || !startEl || !endEl) return;
    function pad(n){ return n.toString().padStart(2,'0'); }
    function updateMins(){
        try {
            const today = new Date();
            const sel = new Date(dateEl.value + 'T00:00:00');
            if (isNaN(sel.getTime())) return;
            if (sel.toDateString() === today.toDateString()) {
                const minStr = pad(today.getHours()) + ':' + pad(today.getMinutes());
                startEl.min = minStr;
                endEl.min = minStr;
            } else {
                startEl.removeAttribute('min');
                endEl.removeAttribute('min');
            }
        } catch(_) {}
    }
    updateMins();
    dateEl.addEventListener('change', updateMins);
})();
</script>
