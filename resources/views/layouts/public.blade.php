<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <title>@yield('title', config('app.name', 'Talent Agency')) - Connecting Talent with Opportunities</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Inter', sans-serif;
            color: #1b1b18;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .btn-primary {
            background-color: #3B82F6;
            border: none;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #2563EB;
        }

        .btn-outline-primary {
            color: #3B82F6;
            border-color: #3B82F6;
        }

        .btn-outline-primary:hover {
            background-color: #3B82F6;
            color: white;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .hero {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 60px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .stat-box {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .stat-box h3 {
            font-size: 2.5rem;
            color: #3B82F6;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-box p {
            color: #6b7280;
            margin: 0;
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .job-card {
            border-left: 4px solid #3B82F6;
        }

        .job-card:hover {
            border-left-color: #2563EB;
        }

        footer {
            background: #1f2937;
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }

        footer a {
            color: #93c5fd;
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 50px;
            color: #1b1b18;
        }

        .section-title .text-primary {
            color: #3B82F6;
        }

        .badge-skill {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="{{ route('public.landing') }}">
                <span>🏢 AgenPekerjaan</span>
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                ☰
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a href="{{ route('public.landing') }}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('public.jobs') }}" class="nav-link">Lowongan Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('public.about') }}" class="nav-link">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">AgenPekerjaan</h5>
                    <p>Platform penempatan kerja terpadu yang menghubungkan talenta terbaik dengan peluang karir yang sempurna.</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Untuk Pencari Kerja</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('public.jobs') }}">Cari Lowongan</a></li>
                        <li><a href="{{ route('register') }}">Buat Profil</a></li>
                        <li><a href="#">Tips Karir</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Untuk Perusahaan</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('register') }}">Posting Lowongan</a></li>
                        <li><a href="#">Cari Talenta</a></li>
                        <li><a href="#">Paket Premium</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled">
                        <li>📧 info@agenpekerjaan.com</li>
                        <li>📱 +62 8xx xxxx xxxx</li>
                        <li>📍 Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center text-muted">
                <p class="mb-0">&copy; 2026 AgenPekerjaan. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
