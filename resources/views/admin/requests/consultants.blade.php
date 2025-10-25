<x-admin.layouts.app>
    <div class="space-y-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ __('Permintaan Konsultan') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Daftar permintaan konsultasi dari pelanggan.') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.requests.consultants.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow ring-1 ring-gray-200 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Export CSV') }}
                </a>
            </div>
        </div>

        <form method="GET" class="grid gap-2 sm:grid-cols-2 lg:grid-cols-6">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="{{ __('Cari nama/email/telepon/kata kunci') }}" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 lg:col-span-3">
            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center rounded-md bg-[#DB4437] px-3 py-2 text-sm font-semibold text-white shadow hover:bg-[#c63c31]">{{ __('Filter') }}</button>
                @if (request()->hasAny(['search','date_from','date_to']))
                    <a href="{{ route('admin.requests.consultants.index') }}" class="text-sm text-gray-600 hover:text-gray-800">{{ __('Reset') }}</a>
                @endif
            </div>
        </form>

        <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Tanggal') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Nama') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Kontak') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Spesialisasi') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Alamat') }}</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($items as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ optional($row->created_at)->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 font-medium text-gray-900">{{ $row->nama }}</td>
                                <td class="px-4 py-2 text-gray-700">
                                    <div>{{ $row->email }}</div>
                                    <div class="text-xs text-gray-500">{{ $row->phone }}</div>
                                </td>
                                <td class="px-4 py-2 text-gray-700">{{ $row->spesialisasi ?: '-' }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ \Illuminate\Support\Str::limit($row->alamat, 80) }}</td>
                                <td class="px-4 py-2 text-right">
                                    <form method="POST" action="{{ route('admin.requests.consultants.destroy', $row) }}" onsubmit="return confirm('{{ __('Hapus permintaan ini?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-md bg-white px-3 py-1.5 text-xs font-medium text-red-600 shadow ring-1 ring-red-200 hover:bg-red-50">{{ __('Hapus') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">{{ __('Belum ada data.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-gray-100 p-3">{{ $items->links() }}</div>
        </div>
    </div>
</x-admin.layouts.app>

