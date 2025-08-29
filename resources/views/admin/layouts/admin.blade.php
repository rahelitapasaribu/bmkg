<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(-45deg, #74b9ff, #0984e3, #81ecec, #a29bfe);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 20px; height: 20px; top: 20%; left: 20%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 15px; height: 15px; top: 60%; left: 80%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 25px; height: 25px; top: 40%; left: 40%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 18px; height: 18px; top: 80%; left: 10%; animation-delay: 1s; }
        .particle:nth-child(5) { width: 22px; height: 22px; top: 10%; left: 90%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem 0;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            text-align: center;
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .sidebar-header h4 {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-header p {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin: 0.5rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #495057;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: all 0.3s ease;
            z-index: -1;
        }

        .nav-link:hover::before {
            left: 0;
        }

        .nav-link:hover {
            color: white;
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .nav-link i {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .content {
            margin-left: 280px;
            min-height: 100vh;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            color: white;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(255, 107, 107, 0.3);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
            color: white;
        }

        /* Content Area */
        .main-content {
            padding: 2rem;
            padding-top: 2rem;
        }

        .content-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Welcome Section */
        .welcome-section {
    text-align: center;
    margin-bottom: 3rem;
    margin-top: 6rem; /* kasih space biar ga nempel header */
}

        .welcome-title {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            animation: fadeInUp 1s ease 0.2s both;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: all 0.3s ease;
            z-index: -1;
            opacity: 0.1;
        }

        .stat-card:hover::before {
            left: 0;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 500;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .content {
                margin-left: 0;
            }
            
            .navbar {
                margin-left: 0;
            }

            .welcome-title {
                font-size: 2rem;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation"></div>
    
    <!-- Floating Particles -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>Admin Panel</h4>
            <p>BMKG Management System</p>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="fas fa-database"></i>
                    Data
                </a>
            </li>
        </ul>
    </div>

    {{-- Header --}}
    <div class="content">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <i class="fas fa-cloud-sun"></i>
                    BMKG Admin
                </span>
                <div class="ms-auto">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        {{-- Main Content --}}
        <div class="main-content pt-3">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1 class="welcome-title">Welcome to BMKG Admin</h1>
                <p class="welcome-subtitle">Manage your meteorological data and operations efficiently</p>
            </div>

            <!-- Content Area -->
            <div class="content-card">
                @yield('content')
                
                <!-- Demo content -->
                <div class="text-center py-5">
                    <h3 class="mb-4">Your content will appear here</h3>
                    <p class="text-muted">This is a modern, responsive admin panel layout with beautiful animations and glassmorphism effects.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const cards = document.querySelectorAll('.stat-card, .content-card');
            
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                    }
                });
            }, observerOptions);
            
            cards.forEach(card => {
                observer.observe(card);
            });
            
            // Add click effect to nav links
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                });
            });
        });
        
        // Add some dynamic particle movement
        const particles = document.querySelectorAll('.particle');
        particles.forEach((particle, index) => {
            setInterval(() => {
                const randomX = Math.random() * 100;
                const randomY = Math.random() * 100;
                particle.style.left = randomX + '%';
                particle.style.top = randomY + '%';
            }, 5000 + (index * 1000));
        });
    </script>
</body>
</html>