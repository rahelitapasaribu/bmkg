<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BMKG Admin Panel')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo-BMKG.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        // Custom Tailwind configuration
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bmkg: {
                            50: '#eff6ff',
                            100: '#dbeafe', 
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transitions */
        * {
            transition: all 0.2s ease-in-out;
        }

        /* Background pattern */
        body {
            background-image: 
                radial-gradient(circle at 25px 25px, rgba(59, 130, 246, 0.1) 2%, transparent 0%), 
                radial-gradient(circle at 75px 75px, rgba(147, 197, 253, 0.1) 2%, transparent 0%);
            background-size: 100px 100px;
        }

        /* Loading animation */
        .loading-spinner {
            border: 3px solid #f3f4f6;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Pulse animation for active states */
        .pulse-dot {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>

<body class="font-sans bg-gray-50 min-h-screen overflow-x-hidden">

    <!-- Mobile Menu Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-br from-bmkg-600 via-bmkg-700 to-bmkg-800 text-white shadow-2xl z-50 transform transition-transform duration-300 lg:translate-x-0 -translate-x-full">
        <!-- Sidebar Header -->
        <div class="relative bg-gradient-to-r from-white/10 to-transparent p-6 border-b border-white/10">
            <div class="flex items-center justify-center flex-col">
                <div class="relative mb-3">
                    <img src="{{ asset('images/Logo-BMKG.png') }}" alt="BMKG Logo"
                        class="w-16 h-16 object-contain drop-shadow-lg">
                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full pulse-dot"></div>
                </div>
                <h1 class="text-lg font-bold text-white tracking-wide">BMKG</h1>
                <p class="text-white/70 text-xs font-medium">Management System</p>
            </div>
            <!-- Mobile close button -->
            <button id="closeSidebar" class="absolute top-4 right-4 lg:hidden text-white/80 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-6">
            <ul class="space-y-2 px-4">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : 'hover:bg-white/10 hover:translate-x-1' }}">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/20' }} mr-3">
                            <i class="fas fa-chart-line text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-medium">Dashboard</span>
                            <p class="text-xs text-white/70">Overview & Analytics</p>
                        </div>
                        @if(request()->routeIs('admin.dashboard'))
                            <i class="fas fa-chevron-right text-sm"></i>
                        @endif
                    </a>
                </li>

                <!-- SLA Management -->
                <li>
                    <a href="{{ route('admin.sla.index') }}"
                        class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.sla.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : 'hover:bg-white/10 hover:translate-x-1' }}">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.sla.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/20' }} mr-3">
                            <i class="fas fa-file-contract text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-medium">SLA Management</span>
                        </div>
                        @if(request()->routeIs('admin.sla.*'))
                            <i class="fas fa-chevron-right text-sm"></i>
                        @endif
                    </a>
                </li>
                <!-- OLA Management -->
                <li>
                    <a href="{{ route('admin.ola.index') }}"
                        class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.ola.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : 'hover:bg-white/10 hover:translate-x-1' }}">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.ola.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/20' }} mr-3">
                            <i class="fas fa-cogs text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-medium">OLA Management</span>
                        </div>
                        @if(request()->routeIs('admin.ola.*'))
                            <i class="fas fa-chevron-right text-sm"></i>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dataupt.index') }}"
                        class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dataupt.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : 'hover:bg-white/10 hover:translate-x-1' }}">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.dataupt.*') ? 'bg-white/20' : 'bg-white/10 group-hover:bg-white/20' }} mr-3">
                            <i class="fas fa-file-contract text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-medium">Data Management</span>
                        </div>
                        @if(request()->routeIs('admin.dataupt.*'))
                            <i class="fas fa-chevron-right text-sm"></i>
                        @endif
                    </a>
                </li>
                <!-- Divider -->
                <li class="px-4 py-2">
                    <div class="border-t border-white/10"></div>
                </li>
            </ul>
        </nav>
        </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 transition-all duration-300">
        <!-- Top Navigation Bar -->
        <nav class="sticky top-0 bg-white/95 backdrop-blur-lg border-b border-gray-200 shadow-sm z-30">
            <div class="flex justify-between items-center px-6 py-4">
                <!-- Left Section -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Button -->
                    <button id="openSidebar" class="lg:hidden p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>

                    <!-- Page Title & Breadcrumb -->
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-cloud-sun text-bmkg-600 mr-2"></i>
                            BMKG Admin Panel
                        </h1>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <span>@yield('title', 'Dashboard')</span>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-medium shadow-lg hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="p-6 min-h-screen">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-4 mb-4 md:mb-0">
                        <img src="{{ asset('images/Logo-BMKG.png') }}" alt="BMKG" class="w-8 h-8 object-contain">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Badan Meteorologi, Klimatologi, dan Geofisika</p>
                            <p class="text-xs text-gray-500">Republic of Indonesia</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 text-center md:text-right">
                        <p>&copy; {{ date('Y') }} BMKG. All rights reserved.</p>
                        <p>Version 2.1.0 | Last updated: {{ date('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');

        function showSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function hideSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        openSidebar?.addEventListener('click', showSidebar);
        closeSidebar?.addEventListener('click', hideSidebar);
        overlay?.addEventListener('click', hideSidebar);

        // Auto-hide sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                hideSidebar();
            }
        });

        // Loading animation for navigation
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.href && !this.href.includes('#')) {
                    const loader = document.createElement('div');
                    loader.className = 'loading-spinner';
                    this.appendChild(loader);
                }
            });
        });

        // Active page highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('nav a');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });

        // Notification badge animation
        const notificationBell = document.querySelector('.fa-bell');
        if (notificationBell) {
            setInterval(() => {
                notificationBell.classList.add('animate-bounce');
                setTimeout(() => {
                    notificationBell.classList.remove('animate-bounce');
                }, 1000);
            }, 10000);
        }
    </script>
</body>

</html>