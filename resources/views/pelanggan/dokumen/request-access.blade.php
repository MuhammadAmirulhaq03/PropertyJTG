<x-app-layout>
    <section class="min-h-screen bg-[#FFF5EE] pt-[4.5rem] pb-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 md:px-10">
            <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-[#DB4437]">Ajukan Peninjauan Dokumen</h1>
                        <p class="text-gray-600 mt-2 text-sm">Pilih agen yang akan meninjau dokumen Anda dan sertakan catatan (opsional).</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mt-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('documents.request.store') }}" method="POST" class="mt-8 space-y-6">
                    @csrf
                    <div>
                        <label for="agent_id" class="block text-sm font-semibold text-gray-700">Pilih Agen</label>
                        <select id="agent_id" name="agent_id" class="mt-2 w-full rounded-2xl border border-[#FFDCC4] bg-[#FFFBF8] px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#DB4437]">
                            <option value="" disabled selected>-- Pilih agen --</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" @selected(old('agent_id') == $agent->id)>
                                    {{ $agent->name }} {{ $agent->email ? '(' . $agent->email . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-semibold text-gray-700">Catatan (Opsional)</label>
                        <textarea id="note" name="note" rows="4" class="mt-2 w-full rounded-2xl border border-[#FFDCC4] bg-[#FFFBF8] px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#DB4437]" placeholder="Tambahkan konteks singkat untuk agen...">{{ old('note') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('documents.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#FFDCC4] text-[#DB4437] text-sm font-semibold hover:bg-[#FFF2E9] transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#DB4437] text-white text-sm font-semibold hover:bg-[#c63c31] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Kirim Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
