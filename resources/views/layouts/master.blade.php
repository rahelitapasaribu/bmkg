<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Landing Page')</title>
    <link rel="icon" type="png" href="{{ asset('images/Logo-BMKG.png') }}">
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

    <!-- Login Button (pojok kanan) -->
    <div class="absolute top-6 right-6 z-20">
        <button onclick="openModal()"
            class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg shadow hover:shadow-lg hover:scale-105 transition-transform">
            Login
        </button>
    </div>

    <!-- Konten Halaman -->
    <main class="w-full px-6 mt-24 mx-auto">
        @yield('content')
    </main>

    {{-- Footer opsional --}}
    @yield('footer')


    <!-- Modal Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content shadow-2xl">
            <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Login Admin</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Username</label>
                    <input type="text" name="username" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>
                <div class="flex justify-between items-center">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">Batal</button>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Styles -->
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

        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
        }

        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 400px;
            animation: fade-in-up 0.4s ease-out;
        }
    </style>

    <!-- Script Modal -->
    <script>
        function openModal() {
            document.getElementById("loginModal").style.display = "block";
        }
        function closeModal() {
            document.getElementById("loginModal").style.display = "none";
        }
        window.onclick = function(event) {
            let modal = document.getElementById("loginModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
