@extends('layouts.public')

@section('title', 'Halaman Utama')

@section('content')
    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Temukan Pekerja sesuai skill yang dibutuhkan</h1>
                    <p>Platform penempatan kerja yang menghubungkan perusahaan Anda dengan pekerja yang siap secara skill di Indonesia.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('public.jobs') }}" class="btn btn-light btn-lg">
                            Cari Lowongan →
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <div style="font-size: 100px; margin: 0;">
                        👔💼📊
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATISTICS SECTION -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="stat-box">
                        <h3>{{ $stats['total_jobs'] }}</h3>
                        <p>Lowongan Kerja Aktif</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stat-box">
                        <h3>{{ $stats['total_companies'] }}</h3>
                        <p>Perusahaan Terpercaya</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stat-box">
                        <h3>{{ $stats['total_placements'] }}</h3>
                        <p>Penempatan Berhasil</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Kenapa Memilih <span class="text-primary">AgenPekerjaan</span>?</h2>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon">🎯</div>
                        <h5 class="card-title fw-bold">Pencarian Mudah</h5>
                        <p class="card-text text-muted">Filter lowongan berdasarkan skill, gaji, dan lokasi yang Anda inginkan.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon">🔐</div>
                        <h5 class="card-title fw-bold">Aman & Terpercaya</h5>
                        <p class="card-text text-muted">Semua perusahaan terverifikasi untuk menjamin kualitas lowongan.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon">⚡</div>
                        <h5 class="card-title fw-bold">Proses Cepat</h5>
                        <p class="card-text text-muted">Dari daftar hingga wawancara, semua proses berjalan efisien.</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon">💡</div>
                        <h5 class="card-title fw-bold">Tips & Panduan</h5>
                        <p class="card-text text-muted">Akses panduan karir dan tips interview dari para ahli.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon">🌐</div>
                        <h5 class="card-title fw-bold">Jangkauan Luas</h5>
                        <p class="card-text text-muted">Ribuan perusahaan di berbagai industri mencari talenta.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon">📈</div>
                        <h5 class="card-title fw-bold">Kemajuan Karir</h5>
                        <p class="card-text text-muted">Tingkatkan skill dan raih peluang karir yang lebih baik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED JOBS SECTION -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Lowongan <span class="text-primary">Terbaru</span></h2>
            
            <div class="row">
                @forelse($featuredJobs as $job)
                    <div class="col-lg-6 mb-4">
                        <div class="card job-card p-4 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title fw-bold mb-2">{{ $job->title }}</h5>
                                    <p class="text-muted mb-0">
                                        <strong>{{ $job->company->name }}</strong> • {{ $job->location }}
                                    </p>
                                </div>
                                <span class="badge bg-light text-primary">{{ $job->status }}</span>
                            </div>
                            
                            <p class="card-text text-muted small">{{ Str::limit($job->description, 100) }}</p>
                            
                            <div class="mb-3">
                                @if($job->salary_min && $job->salary_max)
                                    <p class="text-primary fw-bold mb-2">
                                        Rp {{ number_format($job->salary_min, 0, ',', '.') }} - Rp {{ number_format($job->salary_max, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>

                            @if($job->skills->isNotEmpty())
                                <div class="mb-3">
                                    @foreach($job->skills->take(3) as $skill)
                                        <span class="badge-skill">{{ $skill->name }}</span>
                                    @endforeach
                                    @if($job->skills->count() > 3)
                                        <span class="badge-skill">+{{ $job->skills->count() - 3 }} lagi</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('public.job-detail', $job->id) }}" class="btn btn-primary flex-grow-1">
                                    Lihat Detail
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                    Lamar
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Belum ada lowongan kerja. Silakan cek kembali nanti.</p>
                    </div>
                @endforelse
            </div>

            @if($featuredJobs->isNotEmpty())
                <div class="text-center mt-4">
                    <a href="{{ route('public.jobs') }}" class="btn btn-primary btn-lg">
                        Lihat Semua Lowongan →
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- HOW IT WORKS SECTION -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Cara Kerja <span class="text-primary">AgenPekerjaan</span></h2>
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div style="font-size: 80px; text-align: center;">
                        📋
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <div class="d-flex gap-3 mb-4">
                            <div class="fw-bold text-primary" style="font-size: 1.5rem; min-width: 50px;">1</div>
                            <div>
                                <h5 class="fw-bold">Buat Akun</h5>
                                <p class="text-muted">Daftar dengan email Anda dan lengkapi profil dengan informasi lengkap.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-4">
                            <div class="fw-bold text-primary" style="font-size: 1.5rem; min-width: 50px;">2</div>
                            <div>
                                <h5 class="fw-bold">Cari Lowongan</h5>
                                <p class="text-muted">Jelajahi ribuan lowongan kerja dari perusahaan terpercaya.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-4">
                            <div class="fw-bold text-primary" style="font-size: 1.5rem; min-width: 50px;">3</div>
                            <div>
                                <h5 class="fw-bold">Lamar Pekerjaan</h5>
                                <p class="text-muted">Klik tombol lamar dan bagikan CV/portfolio Anda.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="fw-bold text-primary" style="font-size: 1.5rem; min-width: 50px;">4</div>
                            <div>
                                <h5 class="fw-bold">Dapatkan Pekerjaan</h5>
                                <p class="text-muted">Tunggu respons dari perusahaan dan ikuti proses wawancara.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="py-5">
        <div class="container">
            <div class="card" style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); border: none; color: white;">
                <div class="card-body text-center py-5">
                    <h2 class="card-title fw-bold mb-3">Siap Memulai Karir Impian Anda?</h2>
                    <p class="card-text mb-4" style="font-size: 1.1rem; opacity: 0.95;">
                        Bergabunglah dengan ribuan profesional yang telah menemukan pekerjaan impian mereka melalui AgenPekerjaan.
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            Daftar Gratis
                        </a>
                        <a href="{{ route('public.jobs') }}" class="btn btn-outline-light btn-lg">
                            Cari Lowongan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
