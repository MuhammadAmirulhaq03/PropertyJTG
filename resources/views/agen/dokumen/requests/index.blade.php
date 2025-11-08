<x-app-layout>
    <section class="bg-[#FFF5EE] min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 md:px-10">
            <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-[#DB4437]">Permintaan Peninjauan Dokumen</h1>
                        <p class="text-gray-600 mt-2 text-sm">Daftar permintaan pelanggan yang memilih Anda sebagai agen peninjau.</p>
                    </div>
                </div>

                @if (session('status'))
                    <div class="mt-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-4 py-3 text-sm font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600 border-b border-[#FFDCC4]">
                                <th class="py-3 pr-4">Pelanggan</th>
                                <th class="py-3 pr-4">Email</th>
                                <th class="py-3 pr-4">Catatan</th>
                                <th class="py-3 pr-4">Diminta</th>
                                <th class="py-3 pr-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $req)
                                <tr class="border-b border-[#FFF2E9] hover:bg-[#FFFBF8]">
                                    <td class="py-3 pr-4 font-semibold text-gray-900">{{ optional($req->user)->name }}</td>
                                    <td class="py-3 pr-4 text-gray-600">{{ optional($req->user)->email }}</td>
                                    <td class="py-3 pr-4 text-gray-600 max-w-xs">
                                        <div class="line-clamp-2">{{ $req->note }}</div>
                                    </td>
                                    <td class="py-3 pr-4 text-gray-600">{{ optional($req->requested_at)->diffForHumans() }}</td>
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-2">
                                            <form method="POST" action="{{ route('agent.document-requests.approve', $req) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Setujui
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('agent.document-requests.reject', $req) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-600 text-white font-semibold hover:bg-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">Tidak ada permintaan saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

