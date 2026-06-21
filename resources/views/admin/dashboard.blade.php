@extends('layouts.layouts')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1">Dashboard Admin</h1>
            <p class="text-muted mb-0">Selamat datang kembali! Berikut ringkasan aktivitas sistem hari ini.</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistic Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 bg-primary text-white p-3" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 text-uppercase fw-bold small mb-2">Kandidat Tersedia</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['candidates_available'] }}</h2>
                    </div>
                    <div class="fs-1">👥</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 bg-warning text-dark p-3" style="background: linear-gradient(135deg, #FBBF24, #D97706);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-dark-50 text-uppercase fw-bold small mb-2">Perusahaan Pending</h6>
                        <h2 class="fw-bold mb-0 text-white">{{ $stats['companies_pending'] }}</h2>
                    </div>
                    <div class="fs-1">🏢</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 bg-success text-white p-3" style="background: linear-gradient(135deg, #10B981, #047857);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 text-uppercase fw-bold small mb-2">Lowongan Aktif</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['jobs_active'] }}</h2>
                    </div>
                    <div class="fs-1">💼</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 bg-danger text-white p-3" style="background: linear-gradient(135deg, #EC4899, #BE185D);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white-50 text-uppercase fw-bold small mb-2">Penempatan Sukses</h6>
                        <h2 class="fw-bold mb-0">{{ $stats['placements_success'] }}</h2>
                    </div>
                    <div class="fs-1">✅</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Section -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-transparent border-bottom py-3">
            <h5 class="fw-bold mb-0 text-dark">🏢 Menunggu Verifikasi Perusahaan</h5>
        </div>
        <div class="card-body">
            @if($pendingCompanies->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Industri</th>
                                <th>Email</th>
                                <th>Kontak Person (PIC)</th>
                                <th>Telepon</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingCompanies as $company)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $company->name }}</div>
                                    </td>
                                    <td><span class="badge bg-secondary py-1.5 px-3 rounded-pill">{{ $company->industry ?? '-' }}</span></td>
                                    <td>{{ $company->email ?? $company->user->email }}</td>
                                    <td>{{ $company->contact_person ?? '-' }}</td>
                                    <td>{{ $company->phone ?? '-' }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.companies.verify', $company->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success px-3 rounded-pill fw-bold">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.companies.reject', $company->id) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger px-3 rounded-pill fw-bold" onclick="return confirm('Tolak pendaftaran ini?')">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    Tidak ada pendaftaran perusahaan baru yang menunggu verifikasi.
                </div>
            @endif
        </div>
    </div>

    <!-- Two-column details -->
    <div class="row g-4">
        <!-- Latest Candidates -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">👥 Kandidat Terbaru</h5>
                    <a href="{{ route('admin.candidates.index') }}" class="btn btn-sm btn-link text-decoration-none fw-bold">Semua Kandidat</a>
                </div>
                <div class="card-body">
                    @if($latestCandidates->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($latestCandidates as $candidate)
                                <div class="list-group-item px-0 py-3 border-bottom-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="fw-bold text-dark text-decoration-none mb-1 d-block">{{ $candidate->full_name }}</a>
                                            <span class="text-muted small">{{ $candidate->headline ?? 'Pencari Kerja' }}</span>
                                        </div>
                                        <span class="badge @if($candidate->status === 'tersedia') bg-success @elseif($candidate->status === 'disalurkan') bg-primary @else bg-danger @endif py-1 px-3.5 rounded-pill text-capitalize">{{ $candidate->status }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">Belum ada data kandidat.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest Job Postings -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">💼 Lowongan Terbaru</h5>
                    <a href="{{ route('admin.job-postings.index') }}" class="btn btn-sm btn-link text-decoration-none fw-bold">Semua Lowongan</a>
                </div>
                <div class="card-body">
                    @if($latestJobs->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($latestJobs as $job)
                                <div class="list-group-item px-0 py-3 border-bottom-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <a href="{{ route('admin.job-postings.show', $job->id) }}" class="fw-bold text-dark text-decoration-none mb-1 d-block">{{ $job->title }}</a>
                                            <span class="text-muted small">{{ $job->company->name }} — {{ $job->location ?? 'Remote' }}</span>
                                        </div>
                                        <span class="badge bg-info text-dark py-1 px-3.5 rounded-pill text-capitalize">{{ $job->status }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">Belum ada data lowongan pekerjaan.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection