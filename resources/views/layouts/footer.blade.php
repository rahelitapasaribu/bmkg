<footer class="w-full bg-gray-900 text-white py-14 relative z-20">
    <div class="w-full px-6 max-w-7xl mx-auto">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-10">

            <!-- Logo & Info Section -->
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-white rounded-full p-2 flex items-center justify-center">
                        <img src="{{ asset('images/logo-bmkg.png') }}" alt="BMKG Logo"
                             class="w-full h-full object-contain">
                    </div>
                    <p class="font-bold text-lg leading-snug">
                        Balai Besar Meteorologi, Klimatologi,<br>
                        dan Geofisika Wilayah III
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="space-y-3 text-gray-300">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm">Jl. Raya Tuban, Kuta, Badung, Bali</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm">Phone: (0361) 751122, 753105</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        <span class="text-sm">Email: bbmkg3@bmkg.go.id</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div>
                <h4 class="font-semibold text-lg mb-6 text-blue-400">Main Menu</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-300 hover:text-blue-400 flex items-center gap-2 group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M9 5l7 7-7 7" /></svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('map') }}" class="text-gray-300 hover:text-blue-400 flex items-center gap-2 group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M9 5l7 7-7 7" /></svg>
                            Map
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('upt.index') }}" class="text-gray-300 hover:text-blue-400 flex items-center gap-2 group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M9 5l7 7-7 7" /></svg>
                            Data UPT
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-700 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">
                    © 2025 <span class="text-white font-medium">Balai Besar Meteorologi Klimatologi dan Geofisika Wilayah III Denpasar</span>
                </p>
                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <span class="text-sm">Back to top</span>
                    <svg class="w-4 h-4 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</footer>
