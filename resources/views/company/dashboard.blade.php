@extends('layouts.layouts')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-1">Dashboard Perusahaan</h1>
        <p class="text-muted mb-0">Selamat datang kembali! Pantau lowongan kerja dan proses rekrutmen Anda di sini.</p>
    </div>

    <!-- Alert success -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 p-3 bg-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold small mb-2">Total Lowongan</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $stats['jobs_count'] }}</h2>
                    </div>
                    <div class="fs-1">💼</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 p-3 bg-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold small mb-2">Lowongan Aktif</h6>
                        <h2 class="fw-bold text-success mb-0">{{ $stats['active_jobs'] }}</h2>
                    </div>
                    <div class="fs-1">🟢</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 p-3 bg-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold small mb-2">Pelamar Diproses</h6>
                        <h2 class="fw-bold text-warning mb-0">{{ $stats['placements_count'] }}</h2>
                    </div>
                    <div class="fs-1">👥</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 p-3 bg-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold small mb-2">Diterima Kerja (Hired)</h6>
                        <h2 class="fw-bold text-primary mb-0">{{ $stats['candidates_hired'] }}</h2>
                    </div>
                    <div class="fs-1">🎉</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Job Postings -->
    <div class="row g-4">
        <!-- Lowongan Saya -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 bg-white">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">💼 Lowongan Kerja Terbaru</h5>
                    <a href="{{ route('company.job-postings.index') }}" class="btn btn-sm btn-link text-decoration-none fw-bold">Semua Lowongan</a>
                </div>
                <div class="card-body">
                    @if($latestJobs->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($latestJobs as $job)
                                <div class="list-group-item px-0 py-3 border-bottom-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <a href="{{ route('company.job-postings.show', $job->id) }}" class="fw-bold text-dark text-decoration-none mb-1 d-block">{{ $job->title }}</a>
                                            <span class="text-muted small">📍 {{ $job->location ?? 'Remote' }}</span>
                                        </div>
                                        <span class="badge @if($job->status === 'open') bg-success @else bg-secondary @endif py-1 px-3.5 rounded-pill text-capitalize">{{ $job->status }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">Belum menerbitkan lowongan pekerjaan.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Penyaluran Pelamar -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">🚀 Status Penyaluran Pelamar</h5>
                </div>
                <div class="card-body">
                    @if($latestPlacements->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($latestPlacements as $placement)
                                <div class="list-group-item px-0 py-3 border-bottom-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-bold text-dark mb-1">{{ $placement->candidate->full_name }}</div>
                                            <span class="text-muted small">Lowongan: <span class="fw-semibold">{{ $placement->jobPosting->title }}</span></span>
                                        </div>
                                        <span class="badge @if($placement->status === 'pending') bg-warning text-dark @elseif($placement->status === 'accepted') bg-success @elseif($placement->status === 'completed') bg-primary @else bg-danger @endif py-1 px-3.5 rounded-pill text-capitalize">{{ $placement->status }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">Belum ada aktivitas penyaluran pelamar untuk lowongan Anda.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
