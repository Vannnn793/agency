<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <title>{{ config('app.name', 'Talent Agency') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #3B82F6;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2563EB;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        footer {
            background: #fff;
            padding: 20px 0;
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #eee;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            @php
                $brandUrl = '/login';
                if (auth()->check()) {
                    if (auth()->user()->role === 'admin') {
                        $brandUrl = route('admin.dashboard');
                    } elseif (auth()->user()->role === 'company') {
                        $brandUrl = auth()->user()->isVerified() ? route('company.dashboard') : route('company.pending');
                    }
                }
            @endphp
            <a class="navbar-brand d-flex align-items-center text-primary" href="{{ $brandUrl }}">
                <span class="fs-4 fw-bold tracking-tight">🏢 AgenPekerjaan</span>
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                ☰
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'fw-bold text-primary' : '' }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.candidates.index') }}" class="nav-link {{ request()->routeIs('admin.candidates.*') ? 'fw-bold text-primary' : '' }}">Kandidat</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.companies.index') }}" class="nav-link {{ request()->routeIs('admin.companies.*') ? 'fw-bold text-primary' : '' }}">Perusahaan</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.job-postings.index') }}" class="nav-link {{ request()->routeIs('admin.job-postings.*') ? 'fw-bold text-primary' : '' }}">Lowongan Kerja</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.placements.index') }}" class="nav-link {{ request()->routeIs('admin.placements.*') ? 'fw-bold text-primary' : '' }}">Penempatan</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.skills.index') }}" class="nav-link {{ request()->routeIs('admin.skills.*') ? 'fw-bold text-primary' : '' }}">Skills</a>
                            </li>
                        @elseif (auth()->user()->role === 'company')
                            @if (auth()->user()->isVerified())
                                <li class="nav-item">
                                    <a href="{{ route('company.dashboard') }}" class="nav-link {{ request()->routeIs('company.dashboard') ? 'fw-bold text-primary' : '' }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('company.job-postings.index') }}" class="nav-link {{ request()->routeIs('company.job-postings.*') ? 'fw-bold text-primary' : '' }}">Lowongan Saya</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('company.candidates.index') }}" class="nav-link {{ request()->routeIs('company.candidates.*') ? 'fw-bold text-primary' : '' }}">Cari Pelamar</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <span class="badge bg-warning text-dark px-3 py-2">Menunggu Verifikasi</span>
                                </li>
                            @endif
                        @endif

                        <li class="nav-item ms-3">
                            <span class="text-muted small me-2">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-3">Registrasi Perusahaan</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p class="mb-0 text-muted">
                © {{ date('Y') }} TalentAgency — Connecting Talent with Opportunity
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>