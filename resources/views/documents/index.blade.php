<x-app-layout>
    <section class="bg-[#FFF5EE] min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10">
            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Sidebar placeholder to mimic dashboard navigation -->
                <aside class="lg:w-64 bg-white rounded-3xl shadow-md border border-[#FFDCC4] overflow-hidden">
                    <div class="bg-[#DB4437] text-white px-6 py-6">
                        <p class="text-xs uppercase tracking-widest font-semibold">Dashboard & Profile</p>
                        <p class="text-lg font-bold mt-1">Upload Document</p>
                        <p class="text-sm opacity-80 mt-3">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <nav class="px-4 py-6 space-y-1 text-sm font-medium text-gray-600">
                        <a href="{{ route('homepage') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[#FFF2E9] transition">
                            <span class="w-2 h-2 bg-[#DB4437]/60 rounded-full"></span>
                            Home Page
                        </a>
                        <span class="flex items-center gap-3 px-3 py-2 rounded-xl bg-[#FFF2E9] text-[#DB4437]">
                            <span class="w-2 h-2 bg-[#DB4437] rounded-full"></span>
                            Document
                        </span>
                        <span class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 cursor-not-allowed">
                            <span class="w-2 h-2 bg-gray-200 rounded-full"></span>
                            Favorite (coming soon)
                        </span>
                        <span class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 cursor-not-allowed">
                            <span class="w-2 h-2 bg-gray-200 rounded-full"></span>
                            Search History
                        </span>
                        <span class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 cursor-not-allowed">
                            <span class="w-2 h-2 bg-gray-200 rounded-full"></span>
                            Visit Date
                        </span>
                        <span class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 cursor-not-allowed">
                            <span class="w-2 h-2 bg-gray-200 rounded-full"></span>
                            Consultant
                        </span>
                    </nav>
                </aside>

                <div class="flex-1">
                    <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <h1 class="text-3xl font-bold text-[#DB4437]">Upload Document</h1>
                                <p class="text-gray-600 mt-2">
                                    Unggah dokumen persyaratan KPR kamu. Format yang diterima hanya PDF &amp; JPG (maks {{ $maxFileSizeMb }} MB).
                                </p>
                            </div>
                            <div class="bg-[#FFF2E9] rounded-2xl px-4 py-3 text-sm text-[#DB4437] font-medium shadow-sm">
                                Status dokumen akan diperiksa oleh admin setelah semua berkas terunggah.
                            </div>
                        </div>

                        @if (session('status'))
                            <div class="mt-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-4 py-3 text-sm font-medium">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any() && empty(session('status')))
                            <div class="mt-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3 text-sm">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($requirements as $key => $requirement)
                                @php
                                    $upload = $uploads->get($key);
                                    $hasUpload = !is_null($upload);
                                    $isErrored = old('document_type') === $key && $errors->any();
                                @endphp
                                <div class="rounded-3xl border border-[#FFDCC4] bg-[#FFFBF8] shadow-sm hover:shadow-md transition overflow-hidden">
                                    <div class="p-6 flex flex-col h-full">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <h2 class="text-lg font-semibold text-gray-900">{{ $requirement['label'] }}</h2>
                                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                                    {{ $requirement['description'] }}
                                                </p>
                                            </div>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $hasUpload ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    @if ($hasUpload)
                                                        <path fill-rule="evenodd" d="M16.704 4.29a1 1 0 010 1.42l-7.003 7a1 1 0 01-1.414 0l-2.99-2.99a1 1 0 111.414-1.42l2.283 2.284 6.296-6.296a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    @else
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 9V5a1 1 0 112 0v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4z" clip-rule="evenodd" />
                                                    @endif
                                                </svg>
                                                {{ $hasUpload ? 'Terkirim' : 'Belum ada' }}
                                            </span>
                                        </div>

                                        @if ($hasUpload)
                                            <div class="mt-4 bg-white border border-[#FFE7D6] rounded-2xl px-4 py-3 text-sm text-gray-700 shadow-sm">
                                                <p class="font-semibold truncate">{{ $upload->original_name }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Diunggah {{ $upload->updated_at->diffForHumans() }} • {{ number_format($upload->file_size / 1024, 1) }} KB
                                                </p>
                                                <div class="mt-3 flex items-center gap-3">
                                                    <a 
                                                        href="{{ route('documents.download', $upload) }}" 
                                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#DB4437] text-white text-xs font-semibold hover:bg-[#c63c31] transition"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                                        </svg>
                                                        Lihat Dokumen
                                                    </a>
                                                    <span class="text-xs text-amber-600 font-medium">Status: {{ ucfirst($upload->status) }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <p class="mt-4 text-sm text-gray-500 italic">Belum ada dokumen. Silakan unggah untuk melanjutkan.</p>
                                        @endif

                                        <form class="mt-6" method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="document_type" value="{{ $key }}">
                                            <label class="flex flex-col items-center justify-center gap-3 border-2 border-dashed {{ $isErrored ? 'border-red-300 bg-red-50' : 'border-[#DB4437]/30 bg-white' }} rounded-2xl px-4 py-6 cursor-pointer hover:border-[#DB4437] transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 16V4m0 12l3.5-3.5M12 16l-3.5-3.5M6 20h12a2 2 0 002-2v-5a2 2 0 00-2-2h-3M6 20a2 2 0 01-2-2v-5a2 2 0 012-2h3m0-4a3 3 0 116 0" />
                                                </svg>
                                                <span class="text-sm font-semibold text-[#DB4437]">Pilih atau tarik file ke sini</span>
                                                <span class="text-xs text-gray-500 text-center">PDF atau JPG • Maks {{ $maxFileSizeMb }} MB</span>
                                                <input 
                                                    class="sr-only" 
                                                    type="file" 
                                                    name="document" 
                                                    accept=".pdf,image/jpeg"
                                                    onchange="this.closest('form').querySelector('button[type=submit]').disabled = false;"
                                                >
                                            </label>
                                            @if ($isErrored)
                                                <p class="mt-2 text-xs text-red-600">{{ $errors->first('document') ?? $errors->first('document_type') }}</p>
                                            @endif
                                            <div class="mt-4 flex items-center justify-between">
                                                <span class="text-xs text-gray-400">File baru akan menggantikan dokumen sebelumnya.</span>
                                                <button 
                                                    type="submit" 
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#DB4437] text-white text-sm font-semibold hover:bg-[#c63c31] transition disabled:opacity-50"
                                                    disabled
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                                    </svg>
                                                    Upload
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
