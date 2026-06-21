@extends('layouts.layouts')

@section('content')
<div class="container" style="max-width: 900px;">
    <!-- Navigation -->
    <div class="mb-4">
        <a href="{{ route('admin.companies.index') }}" class="btn btn-link text-decoration-none p-0 fw-bold">← Kembali ke Daftar Perusahaan</a>
    </div>

    <!-- Company Detail Profile Card -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                    <div class="rounded bg-light d-flex align-items-center justify-content-center mx-auto text-primary fw-bold" style="width: 80px; height: 80px; font-size: 2.5rem;">
                        🏢
                    </div>
                </div>
                <div class="col-md-7 text-center text-md-start">
                    <h2 class="fw-bold mb-1">{{ $company->name }}</h2>
                    <p class="text-secondary mb-2">{{ $company->industry ?? 'Sektor Usaha Belum Diisi' }}</p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 text-muted small">
                        <span>📧 {{ $company->email ?? $company->user->email }}</span>
                        <span>📞 {{ $company->phone ?? '-' }}</span>
                        <span>👤 PIC: {{ $company->contact_person ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-3 text-center text-md-end mt-3 mt-md-0">
                    @if($company->user->verified_at)
                        <span class="badge bg-success px-4 py-2 rounded-pill fs-6">Terverifikasi</span>
                    @else
                        <span class="badge bg-warning text-dark px-4 py-2 rounded-pill fs-6">Pending Verifikasi</span>
                    @endif
                </div>
            </div>

            <!-- Verification Actions if pending -->
            @if(!$company->user->verified_at)
                <div class="mt-4 pt-3 border-top bg-light p-3 rounded d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <span class="fw-semibold text-dark">Perusahaan ini memerlukan verifikasi Anda agar dapat mempublikasikan lowongan.</span>
                    </div>
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.companies.verify', $company->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success rounded-pill px-4 fw-bold">Setujui & Verifikasi</button>
                        </form>
                        <form action="{{ route('admin.companies.reject', $company->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger rounded-pill px-4 fw-bold" onclick="return confirm('Tolak pendaftaran ini?')">Tolak & Hapus</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile details -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 mb-4 h-100">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">📝 Profil Perusahaan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-semibold text-muted small mb-2">Tentang Perusahaan</h6>
                        <p class="text-secondary mb-0" style="white-space: pre-line;">{{ $company->description ?? 'Belum ada deskripsi yang ditambahkan.' }}</p>
                    </div>

                    <div class="mb-0">
                        <h6 class="fw-semibold text-muted small mb-2">Alamat Kantor</h6>
                        <p class="text-secondary mb-0">{{ $company->address ?? 'Belum ada alamat kantor yang ditambahkan.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job postings list -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 mb-4 h-100">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">💼 Daftar Lowongan Kerja</h5>
                </div>
                <div class="card-body">
                    @forelse($company->jobPostings as $job)
                        <div class="border-bottom pb-3 mb-3">
                            <h6 class="fw-bold mb-1">
                                <a href="{{ route('admin.job-postings.show', $job->id) }}" class="text-dark text-decoration-none">{{ $job->title }}</a>
                            </h6>
                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                <span>📍 {{ $job->location ?? 'Remote' }}</span>
                                <span class="badge @if($job->status === 'open') bg-success @else bg-secondary @endif py-1 px-2.5 rounded-pill text-capitalize">{{ $job->status }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">Belum menerbitkan lowongan pekerjaan.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
