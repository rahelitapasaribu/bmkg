@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <!-- Full Body Background Style -->
    <style>
        body {
            background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 50%, #f3e8ff 100%);
            min-height: 100vh;
        }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Floating Circles -->
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-200/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
            <div class="absolute top-1/2 right-1/4 w-32 h-32 bg-indigo-300/40 rounded-full blur-2xl animate-bounce delay-500"></div>
            
            <!-- Grid Pattern -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%234F46E5" fill-opacity="0.03"%3E%3Cpath d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        </div>
        
        <div class="relative z-10 container mx-auto px-6 py-16">
            
            <!-- Header Section -->
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                
                <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-6 leading-tight">
                    Selamat Datang
                </h1>
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-4">
                    Sistem Informasi BMKG
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full mx-auto"></div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-16 max-w-7xl mx-auto">

                <!-- Left Column: Mascot with Enhanced Design -->
                <div class="flex justify-center lg:justify-start animate-fade-in-left">
                    <div class="relative group">
                        <!-- Glow Effect Behind Mascot -->
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-500/20 rounded-full blur-2xl scale-110 group-hover:scale-125 transition-transform duration-700"></div>
                        
                        <!-- Mascot Container -->
                        <div class="relative bg-white/70 backdrop-blur-sm rounded-3xl p-8 shadow-2xl border border-white/20 group-hover:shadow-3xl transition-all duration-500 transform group-hover:-translate-y-2">
                            <img src="{{ asset('images/maskot_bmkg.svg') }}" alt="Maskot BMKG" 
                                 class="w-72 md:w-80 lg:w-96 transform group-hover:scale-105 transition-transform duration-500 filter drop-shadow-lg">
                        </div>
                        
                        <!-- Floating Elements Around Mascot -->
                        <div class="absolute -top-4 -right-4 w-8 h-8 bg-yellow-400 rounded-full animate-ping opacity-75"></div>
                        <div class="absolute -bottom-6 -left-6 w-6 h-6 bg-blue-500 rounded-full animate-bounce delay-300"></div>
                    </div>
                </div>

                <!-- Right Column: Content -->
                <div class="flex flex-col items-center lg:items-start gap-8 animate-fade-in-right">
                    
                    <!-- Description Card -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Informasi Terintegrasi</h3>
                                <p class="text-lg text-gray-600 leading-relaxed">
                                    Pantau data dan informasi UPT dengan mudah dan akurat. 
                                    Sistem ini menyediakan akses cepat dan terintegrasi untuk seluruh unit kerja 
                                    dalam satu platform yang user-friendly.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Feature Pills -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-medium">Real-time Data</span>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm font-medium">Cloud Integration</span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-medium">Secure Access</span>
                        </div>

                        <!-- CTA Button -->
                        <button class="group inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                            <span>Mulai Eksplorasi</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Map Section -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 w-full max-w-md">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Cakupan Nasional</h3>
                        </div>
                        
                        <div class="relative group cursor-pointer">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-200/20 to-blue-200/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                            <img src="{{ asset('images/map.svg') }}" alt="Peta Indonesia" 
                                 class="relative w-full rounded-xl shadow-lg group-hover:shadow-xl transition-all duration-500 transform group-hover:scale-105">
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-3 text-center">
                            Melayani seluruh wilayah Indonesia dengan jaringan UPT terpadu
                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-4 gap-6 max-w-4xl mx-auto animate-fade-in-up">
                <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-3xl font-bold text-blue-600 mb-2">50+</div>
                    <div class="text-gray-600 font-medium">UPT Aktif</div>
                </div>
                <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-3xl font-bold text-indigo-600 mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">Monitoring</div>
                </div>
                <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-3xl font-bold text-purple-600 mb-2">99.9%</div>
                    <div class="text-gray-600 font-medium">Uptime</div>
                </div>
                <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-3xl font-bold text-green-600 mb-2">1000+</div>
                    <div class="text-gray-600 font-medium">Pengguna</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-gray-900 text-white py-16 relative z-20">
        <div class="container mx-auto px-6">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-12">
                
                <!-- Logo & Info Section -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-white rounded-full p-2 flex items-center justify-center">
                            <img src="{{ asset('images/logo-bmkg.png') }}" alt="BMKG Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="font-bold text-lg">Balai Besar Meteorologi, Klimatologi, dan Geofisika Wilayah III</p>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="space-y-3 text-gray-300">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm">Jl. Raya Tuban, Kuta, Badung, Bali</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-sm">Phone: (0361) 751122, 753105</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">Email: bbmkg3@bmkg.go.id</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
    <div class="lg:col-span-1">
        <h4 class="font-semibold text-lg mb-6 text-blue-400">Main Menu</h4>
        <ul class="space-y-3">
            <li>
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('map') }}" class="text-gray-300 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Map
                </a>
            </li>
            <li>
                <a href="{{ route('upt.index') }}" class="text-gray-300 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Data UPT
                </a>
            </li>
        </ul>
    </div>


                <!-- Mobile App & Social Media -->
                <div class="lg:col-span-1">
                    <h4 class="font-semibold text-lg mb-6 text-blue-400">Mobile App</h4>
                    
                    <!-- App Store Buttons -->
                    <div class="space-y-3 mb-8">
                        <a href="https://apps.apple.com/id/app/info-bmkg/id1114372539?l=id" target="_blank" class="inline-block hover:opacity-80 transition-opacity">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" 
                                 alt="Download on App Store" class="h-12">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.Info_BMKG" target="_blank" class="inline-block hover:opacity-80 transition-opacity">
                            <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" 
                                 alt="Get it on Google Play" class="h-12">
                        </a>
                    </div>

                    <!-- Social Media -->
                    <h4 class="font-semibold text-lg mb-4 text-blue-400">Follow Us</h4>
                    <div class="flex gap-4">
                        <a href="https://x.com/bbmkg3" target="_blank" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition-colors duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="https://web.facebook.com/BBMKG-Wilayah-III-Denpasar-470006976450591/" target="_blank" class="w-10 h-10 bg-blue-800 hover:bg-blue-900 rounded-full flex items-center justify-center transition-colors duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/bmkgbali/?hl=id" target="_blank" class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-full flex items-center justify-center transition-colors duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm">
                        © 2025 <span class="text-white font-medium">Balai Besar Meteorologi Klimatologi dan Geofisika Wilayah III Denpasar</span>
                    </p>
                    
                    <!-- Back to Top Button -->
                    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                            class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                        <span class="text-sm">Back to top</span>
                        <svg class="w-4 h-4 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Custom Styles untuk Animasi -->
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-left {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fade-in-right {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out;
        }

        .animate-fade-in-left {
            animation: fade-in-left 0.8s ease-out 0.2s both;
        }

        .animate-fade-in-right {
            animation: fade-in-right 0.8s ease-out 0.4s both;
        }

        .shadow-3xl {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
@endsection