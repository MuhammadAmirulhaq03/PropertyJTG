<!-- Footer Section -->
<footer class="bg-[#DB4437] text-white py-10 font-['Roboto']">
    <div class="container mx-auto px-6 md:px-20 grid grid-cols-1 md:grid-cols-3 gap-10">
        
        <!-- Left Section -->
        <div>
            <div class="flex items-center space-x-3 mb-3">
                <img src="{{ asset('assets/jtg.png') }}" alt="Logo" class="block h-12 w-12 p-0.5 rounded-lg ring-2 ring-white ring-offset-0 shadow-sm">
                <div>
                    <h2 class="text-lg font-bold">JAYA TIBAR GROUP</h2>
                    <p class="text-sm">Real Estate Management Platform</p>
                </div>
            </div>

            <p class="text-sm mb-4">
                {{ __('Solusi manajemen properti dan layanan pelanggan Jaya Tibar Group. Hubungi kami untuk informasi listing, jadwal kunjungan, maupun dukungan dokumen.') }}
            </p>

            <div class="flex space-x-4 text-xl">
                <a href="https://www.instagram.com/districtland.jtgtibar?igsh=N2F4MThjYmJ5Njdm" target="_blank" rel="noopener" class="hover:text-gray-200 transition" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                    <span class="sr-only">Instagram</span>
                </a>
            </div>
        </div>

        <!-- Middle Section -->
        <div>
            <h3 class="text-lg font-semibold mb-3">{{ __('Company') }}</h3>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="{{ route('homepage') }}#faq" class="hover:underline">{{ __('FAQs') }}</a>
                </li>
                <li>
                    <a href="{{ route('gallery.index') }}" class="hover:underline">{{ __('Services') }}</a>
                </li>
                <li>
                    <a href="{{ route('homepage') }}#about" class="hover:underline">{{ __('About Us') }}</a>
                </li>
            </ul>
        </div>

        <!-- Right Section -->
        <div>
            <h3 class="text-lg font-semibold mb-3">{{ __('Contact') }}</h3>
            <ul class="space-y-2 text-sm">
                <li><strong>{{ __('Email') }}:</strong> jtg.tibar@gmail.com</li>
                <li><strong>{{ __('Contact Developer PT') }}:</strong> 0895401550972 (Admin)</li>
                <li><strong>{{ __('Contact Konstruksi & Konsultan') }}:</strong> 087821752151</li>
                <li>Jl. Dona-dona, RT 24, RW 4 Karya Indah, Kec. Tapung, Kabupaten Kampar, Riau</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/30 mt-10 pt-4 text-center text-xs">
        © 2025 Jaya Tibar Group. All rights reserved.
    </div>
</footer>
