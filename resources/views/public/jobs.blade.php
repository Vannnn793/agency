@extends('layouts.public')

@section('title', 'Lowongan Kerja')

@section('content')
    <!-- HEADER SECTION -->
    <div style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; padding: 40px 0; margin-bottom: 40px;">
        <div class="container">
            <h1 class="fw-bold mb-3">Cari Lowongan Kerja</h1>
            <p class="mb-0">Temukan pekerjaan yang sesuai dengan skill dan preferensi Anda</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <!-- FILTER SIDEBAR -->
            <div class="col-lg-3 mb-4">
                <div class="card p-4">
                    <h5 class="card-title fw-bold mb-4">Filter Pencarian</h5>
                    
                    <form method="GET" action="{{ route('public.jobs') }}">
                        <!-- Location Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" name="location" class="form-control" placeholder="Cari lokasi..." value="{{ request('location') }}">
                        </div>

                        <!-- Salary Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gaji Minimum (Rp)</label>
                            <input type="number" name="salary_min" class="form-control" placeholder="Masukkan jumlah" value="{{ request('salary_min') }}">
                        </div>

                        <!-- Status Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua</option>
                                <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Dibuka</option>
                                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Ditutup</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                🔍 Cari
                            </button>
                            <a href="{{ route('public.jobs') }}" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- JOBS LIST -->
            <div class="col-lg-9">
                @forelse($jobs as $job)
                    <div class="card job-card p-4 mb-4">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title fw-bold mb-2">{{ $job->title }}</h5>
                                <p class="text-muted mb-3">
                                    <strong>{{ $job->company->name }}</strong> • 📍 {{ $job->location }}
                                </p>
                                <p class="card-text text-muted">{{ Str::limit($job->description, 150) }}</p>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    @if($job->salary_min && $job->salary_max)
                                        <p class="text-primary fw-bold mb-2">
                                            Rp {{ number_format($job->salary_min, 0, ',', '.') }} - 
                                        </p>
                                        <p class="text-primary fw-bold">
                                            Rp {{ number_format($job->salary_max, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-muted">Gaji negosiasi</p>
                                    @endif
                                </div>
                                <span class="badge bg-light text-primary">{{ $job->status }}</span>
                            </div>
                        </div>

                        @if($job->skills->isNotEmpty())
                            <div class="mb-3 mt-3">
                                <strong class="text-muted" style="font-size: 0.875rem;">Skills yang diperlukan:</strong>
                                <div class="mt-2">
                                    @foreach($job->skills->take(5) as $skill)
                                        <span class="badge-skill">{{ $skill->name }}</span>
                                    @endforeach
                                    @if($job->skills->count() > 5)
                                        <span class="badge-skill">+{{ $job->skills->count() - 5 }} lagi</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex gap-2">
                                <a href="{{ route('public.job-detail', $job->id) }}" class="btn btn-primary">
                                    Lihat Detail
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                    Lamar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card p-5 text-center">
                        <p class="text-muted mb-0">Tidak ada lowongan kerja yang ditemukan.</p>
                    </div>
                @endforelse

                <!-- PAGINATION -->
                @if($jobs->hasPages())
                    <nav class="mt-5">
                        {{ $jobs->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
            </div>
        </div>
    </div>
@endsection
