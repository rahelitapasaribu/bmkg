<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Landing Page')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen flex flex-col items-center justify-center bg-white">

    <!-- Background -->
    <div class="absolute inset-0 -z-10">
        <div
            class="h-full w-full rotate-180 transform 
                bg-[radial-gradient(60%_120%_at_50%_50%,hsla(0,0%,100%,0)_0,rgba(1,55,125,0.3)_100%)]">
        </div>
    </div>

    <!-- Navbar -->
    <nav
        class="absolute top-5 left-1/2 transform -translate-x-1/2 flex items-center gap-8 
          bg-white/80 backdrop-blur-md px-6 py-3 rounded-2xl shadow-md z-10">
        <a href="{{ url('/') }}" class="font-semibold text-gray-700 hover:text-[#01377D]">Home</a>
        <a href="{{ url('/map') }}" class="font-semibold text-gray-700 hover:text-[#01377D]">Map</a>
        <a href="{{ url('/data-upt') }}" class="font-semibold text-gray-700 hover:text-[#01377D]">Data UPT</a>
    </nav>

    <!-- Logo -->
    <div class="absolute top-5 left-5 z-10">
        <img src="{{ asset('images/Logo-BMKG.png') }}" alt="Logo Instansi" class="h-12 w-auto">
    </div>


    <!-- Konten Halaman -->
    <main class="w-full px-6 mt-24 mx-auto">
        @yield('content')
    </main>

</body>

</html>
