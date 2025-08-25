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
    <div class="relative overflow-visible w-full">

        <div class="relative z-10 max-w-7xl mx-auto px-6 py-16">

            <!-- Header Section -->
            <div class="text-center mb-16 animate-fade-in-up">
                <h1
                    class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-6 leading-normal overflow-visible">
                    Selamat Datang
                </h1>
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-4">
                    Sistem Informasi BMKG Wilayah III
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full mx-auto"></div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-16 w-full">

                <!-- Left Column: Maskot -->
                <div class="flex justify-center lg:justify-start animate-fade-in-left">
                    <div class="relative group">
                        <img src="{{ asset('images/maskot_bmkg.svg') }}" alt="Maskot BMKG"
                            class="w-80 md:w-96 lg:w-[28rem] transform group-hover:scale-105 transition-transform duration-500 filter drop-shadow-lg ml-6">

                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 w-8 h-8 bg-yellow-400 rounded-full animate-ping opacity-75">
                        </div>
                        <div class="absolute -bottom-6 -left-6 w-6 h-6 bg-blue-500 rounded-full animate-bounce delay-300">
                        </div>
                    </div>
                </div>

                <!-- Right Column: Content -->
                <div class="flex flex-col items-center lg:items-start gap-8 animate-fade-in-right">

                    <!-- Description Card -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Informasi Terintegrasi</h3>
                                <p class="text-lg text-gray-600 leading-relaxed">
                                    Pantau data dan informasi UPT dengan mudah.
                                    Sistem ini menyediakan akses untuk seluruh unit kerja
                                    dalam satu platform.
                                </p>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <a href="{{ route('map') }}"
                            class="group inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 
                            hover:from-blue-600 hover:to-indigo-700 text-white font-semibold px-6 py-3 
                            rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 
                            transition-all duration-300">
                            <span>Mulai Eksplorasi</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>

                    </div>

                    <!-- Map Section -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 w-full">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Cakupan BMKG Wilayah III</h3>
                        </div>

                        <div class="relative group cursor-pointer">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-green-200/20 to-blue-200/20 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-500">
                            </div>
                            <img src="{{ asset('images/map.svg') }}" alt="Peta Indonesia"
                                class="relative w-full rounded-xl shadow-lg group-hover:shadow-xl transition-all duration-500 transform group-hover:scale-105">
                        </div>

                        <p class="text-sm text-gray-600 mt-3 text-center">
                            Melayani seluruh UPT yang berada dibawah BMKG Wilayah III
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

@section('footer')
    @include('layouts.footer')
@endsection
