@php
    use App\Models\DocumentUpload;
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-gray-400">
                    {{ __('Agent Workspace') }}
                </p>
                <h2 class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">
                    {{ __('Document Review') }} &mdash; {{ $user->name }}
                </h2>
                <p class="mt-2 text-sm text-gray-500 max-w-2xl">
                    {{ __('Verify each uploaded document, leave friendly notes, and mark the next action for the customer.') }}
                </p>
            </div>
            <a href="{{ route('agent.documents.index', array_filter($filters)) }}"
                class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:-translate-y-0.5 hover:border-[#DB4437]/40 hover:text-[#DB4437]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12H3m12 0l-4-4m4 4l-4 4" />
                </svg>
                {{ __('Back to customers') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-white via-[#FFF7F1] to-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div
                    class="rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($documents->isEmpty())
                <div
                    class="rounded-3xl border border-dashed border-[#DB4437]/40 bg-white/60 p-10 text-center text-sm text-gray-500">
                    {{ __('This customer has not uploaded any documents yet.') }}
                </div>
            @endif

            @foreach ($documents as $document)
                @php
                    $requirement = $requirements[$document->document_type] ?? null;
                @endphp
                <article
                    class="rounded-3xl border border-[#FFE7D6] bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex flex-col gap-4 md:flex-row md:justify-between">
                        <div class="space-y-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $requirement['label'] ?? Str::headline(str_replace('_', ' ', $document->document_type)) }}
                                </h3>
                                <span
                                    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $document->statusBadgeClass() }}">
                                    {{ $document->statusLabel() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">
                                {{ $requirement['description'] ?? __('No description provided for this document type.') }}
                            </p>
                            <dl class="flex flex-wrap gap-4 text-xs text-gray-500">
                                <div>
                                    <dt class="font-semibold uppercase tracking-wide">{{ __('Uploaded on') }}</dt>
                                    <dd>{{ $document->created_at?->format('d M Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold uppercase tracking-wide">{{ __('Last updated') }}</dt>
                                    <dd>{{ $document->updated_at?->diffForHumans() }}</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold uppercase tracking-wide">{{ __('File name') }}</dt>
                                    <dd>{{ $document->original_name }}</dd>
                                </div>
                            </dl>
                            <div>
                                <a href="{{ route('agent.documents.download', $document) }}"
                                    class="inline-flex items-center gap-2 rounded-full bg-[#DB4437]/10 px-4 py-2 text-xs font-semibold text-[#DB4437] transition hover:bg-[#DB4437]/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                    </svg>
                                    {{ __('Download file') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('agent.documents.update', $document) }}"
                        class="mt-6 space-y-3">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="document_id" value="{{ $document->id }}">
                        <input type="hidden" name="redirect_to" value="customer">
                        <input type="hidden" name="filter_status" value="{{ $filters['status'] }}">
                        <input type="hidden" name="filter_document_type" value="{{ $filters['document_type'] }}">
                        <input type="hidden" name="filter_search" value="{{ $filters['search'] }}">

                        <label class="block text-sm font-semibold text-gray-700">
                            {{ __('Review notes to customer') }}
                            <textarea
                                name="review_notes"
                                rows="4"
                                class="mt-2 w-full rounded-2xl border-gray-200 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]"
                                placeholder="{{ __('Let the customer know what to fix or congratulate them on approval.') }}">{{ old('document_id') == $document->id ? old('review_notes') : $document->review_notes }}</textarea>
                        </label>

                        @if (old('document_id') == $document->id && $errors->has('review_notes'))
                            <p class="text-xs font-semibold text-red-600">
                                {{ $errors->first('review_notes') }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center justify-end gap-2">
                            <button type="submit" name="status"
                                value="{{ DocumentUpload::STATUS_APPROVED }}"
                                class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-emerald-600">
                                {{ __('Mark as accepted') }}
                            </button>
                            <button type="submit" name="status"
                                value="{{ DocumentUpload::STATUS_REVISION }}"
                                class="inline-flex items-center gap-2 rounded-full bg-amber-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-amber-600">
                                {{ __('Request revision') }}
                            </button>
                            <button type="submit" name="status"
                                value="{{ DocumentUpload::STATUS_REJECTED }}"
                                class="inline-flex items-center gap-2 rounded-full bg-red-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-red-600">
                                {{ __('Reject document') }}
                            </button>
                        </div>

                        @if (old('document_id') == $document->id && $errors->has('status'))
                            <p class="text-xs font-semibold text-red-600 text-right">
                                {{ $errors->first('status') }}
                            </p>
                        @endif
                    </form>
                </article>
            @endforeach
        </div>
    </div>
</x-app-layout>
