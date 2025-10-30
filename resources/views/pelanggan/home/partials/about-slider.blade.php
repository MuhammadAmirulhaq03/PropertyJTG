<section class="bg-gradient-to-br from-[#FFF2E9] via-[#FFE7D6]/50 to-[#FFF2E9] py-16 px-4 sm:px-6 md:px-10 relative overflow-hidden">
    <div class="max-w-7xl mx-auto grid gap-8 md:grid-cols-2 items-center">
        <!-- Left: Image Carousel -->
        <div
            x-data="{
                i: 0,
                n: {{ ($aboutSlides ?? collect())->count() }},
                t: null,
                start(){ this.stop(); if (this.n > 1) this.t = setInterval(()=> this.next(), 5000); },
                stop(){ if (this.t) { clearInterval(this.t); this.t = null; } },
                next(){ this.i = (this.i + 1) % this.n; },
                prev(){ this.i = (this.i - 1 + this.n) % this.n; }
            }"
            x-init="start()"
            @mouseenter="stop()" @mouseleave="start()"
            class="relative w-full"
        >
            <div class="relative h-64 sm:h-80 md:h-96 rounded-3xl overflow-hidden shadow-lg border border-[#FFE7D6] bg-white">
                @foreach (($aboutSlides ?? collect()) as $img)
                    <img
                        src="{{ $img }}"
                        alt="About JTG {{ $loop->iteration }}"
                        class="absolute inset-0 h-full w-full object-cover"
                        x-show="i === {{ $loop->index }}"
                        x-transition.opacity.duration.400ms
                        loading="lazy"
                    />
                @endforeach
            </div>
            <div class="mt-4 flex items-center justify-between">
                <button type="button" @click="prev()" class="inline-flex items-center gap-2 rounded-full border border-[#DB4437]/30 bg-white px-4 py-2 text-sm font-semibold text-[#DB4437] hover:bg-[#FFF2E9] transition">‹</button>
                <div class="flex items-center gap-1.5">
                    @foreach (($aboutSlides ?? collect()) as $img)
                        <button type="button" @click="i={{ $loop->index }}" class="h-2.5 w-2.5 rounded-full transition" :class="i==={{ $loop->index }} ? 'bg-[#DB4437]' : 'bg-[#DB4437]/30'"></button>
                    @endforeach
                </div>
                <button type="button" @click="next()" class="inline-flex items-center gap-2 rounded-full border border-[#DB4437]/30 bg-white px-4 py-2 text-sm font-semibold text-[#DB4437] hover:bg-[#FFF2E9] transition">›</button>
            </div>
        </div>

        <!-- Right: Static Text (with a subtle pulse effect when image changes) -->
        <div x-data="{pulse:false}" x-effect="i; pulse=true; setTimeout(()=>pulse=false,250)" class="md:pl-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center gap-2">
                {{ __('About Jaya Tibar Group') }}
                <span :class="pulse ? 'opacity-100' : 'opacity-0'" class="inline-block h-2 w-2 rounded-full bg-[#DB4437] transition-opacity duration-200"></span>
            </h2>
            <p class="mt-4 text-sm sm:text-base leading-relaxed text-gray-700">
                {{ $aboutText ?? '' }}
            </p>
            <a href="{{ route('gallery.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-5 py-2 text-sm font-semibold text-white shadow hover:bg-[#c63c31] transition">
                {{ __('Explore Our Projects') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>
