<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" type="png" href="{{ asset('images/Logo-BMKG.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="font-sans bg-gray-100 min-h-screen overflow-x-hidden">

    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-screen w-60 bg-gradient-to-b from-blue-500 to-blue-700 text-white shadow-lg">
        <div class="text-center pb-4 mb-6 px-4 pt-6">
            <img src="{{ asset('images/Logo-BMKG.png') }}" alt="logo-bmkg"
                class="w-20 h-20 mx-auto mb-2 object-contain">
            <p class="text-white/80 text-xs">BMKG Management System</p>
        </div>

        <nav>
            <ul class="space-y-1 px-3">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-2 rounded-md hover:bg-white/20 transition">
                        <i class="fas fa-tachometer-alt mr-3 w-5"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ola.index') }}"
                        class="flex items-center px-4 py-2 rounded-md hover:bg-white/20 transition">
                        <i class="fas fa-cogs mr-3 w-5"></i> OLA
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.sla.index') }}"
                        class="flex items-center px-4 py-2 rounded-md hover:bg-white/20 transition">
                        <i class="fas fa-file-contract mr-3 w-5"></i> SLA
                    </a>
                </li>
            </ul>
        </nav>

    </aside>

    <!-- Content -->
    <main class="ml-60 bg-white min-h-screen">
        <!-- Navbar -->
        <nav
            class="fixed top-0 left-60 right-0 bg-white border-b border-gray-200 shadow flex justify-between items-center px-6 py-4 z-10">
            <span class="font-bold text-lg text-blue-600">
                <i class="fas fa-cloud-sun mr-2"></i> BMKG Admin
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-red-600 text-white text-sm font-medium shadow hover:bg-red-700 transition">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </nav>

        <!-- Page Content -->
        <div class="pt-24 px-8 pb-10">
            @yield('content')
        </div>
    </main>
</body>

</html>
