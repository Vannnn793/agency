@extends('layouts.layouts')

@section('content')
<div class="container" style="max-width: 1000px;">
    <!-- Navigation -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('company.job-postings.index') }}" class="btn btn-link text-decoration-none p-0 fw-bold">← Kembali ke Lowongan Kerja Saya</a>
        <div>
            <a href="{{ route('company.job-postings.edit', $jobPosting->id) }}" class="btn btn-primary rounded-pill px-4 fw-bold">Edit Lowongan</a>
        </div>
    </div>

    <!-- Job Header Card -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <h2 class="fw-bold mb-1">{{ $jobPosting->title }}</h2>
                    <p class="text-primary fw-semibold mb-2">Internal Recruitment</p>
                    <div class="d-flex flex-wrap gap-3 text-muted small">
                        <span>📍 {{ $jobPosting->location ?? 'Remote / Seluruh Indonesia' }}</span>
                        <span>💰 Gaji: 
                            @if($jobPosting->salary_min || $jobPosting->salary_max)
                                {{ $jobPosting->salary_min ? 'Rp ' . number_format($jobPosting->salary_min, 0, ',', '.') : '-' }} - 
                                {{ $jobPosting->salary_max ? 'Rp ' . number_format($jobPosting->salary_max, 0, ',', '.') : '-' }}
                            @else
                                Nego
                            @endif
                        </span>
                        <span>🎓 Syarat: {{ $jobPosting->education_requirement ?? 'Semua Pendidikan' }}</span>
                        <span>⏱️ Pengalaman: {{ $jobPosting->experience_years ? $jobPosting->experience_years . ' Tahun' : 'Fresh Graduate' }}</span>
                    </div>
                </div>
                <span class="badge @if($jobPosting->status === 'open') bg-success @elseif($jobPosting->status === 'closed') bg-secondary @else bg-info text-dark @endif px-4 py-2 rounded-pill fs-6 text-capitalize font-bold">
                    Status: {{ $jobPosting->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Details Column -->
        <div class="col-lg-6">
            <!-- Job Description -->
            <div class="card shadow-sm border-0 mb-4 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">📝 Deskripsi Pekerjaan & Kualifikasi</h5>
                </div>
                <div class="card-body">
                    <p class="text-secondary" style="white-space: pre-line;">{{ $jobPosting->description ?? 'Belum ada rincian deskripsi.' }}</p>
                </div>
            </div>

            <!-- Required Skills -->
            <div class="card shadow-sm border-0 mb-4 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">⚡ Keahlian yang Dibutuhkan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($jobPosting->skills as $skill)
                            <span class="badge bg-light text-primary border border-primary-subtle py-2 px-3 rounded-pill text-dark small">{{ $skill->name }}</span>
                        @empty
                            <span class="text-muted small">Tidak membutuhkan keahlian spesifik.</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Existing Placements status -->
            <div class="card shadow-sm border-0 mb-4 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">👥 Status Penempatan Pelamar</h5>
                </div>
                <div class="card-body">
                    @forelse($jobPosting->placements as $placement)
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div>
                                <div class="fw-bold text-dark mb-1">{{ $placement->candidate->full_name }}</div>
                                <span class="text-muted small">Hubungan Terjalin: {{ $placement->created_at->format('d M Y') }}</span>
                            </div>
                            <span class="badge @if($placement->status === 'pending') bg-warning text-dark @elseif($placement->status === 'accepted') bg-success @elseif($placement->status === 'completed') bg-primary @else bg-danger @endif py-1 px-2.5 rounded-pill text-capitalize small">{{ $placement->status }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0 small">Belum ada penyaluran pelamar terjadwal oleh Admin untuk lowongan ini.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Matching Candidates Column -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4 bg-white">
                <div class="card-header bg-primary text-white py-3" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                    <h5 class="fw-bold mb-0">🤖 Rekomendasi Pelamar Cocok</h5>
                    <span class="small opacity-75">Kandidat terdaftar yang paling cocok untuk kriteria Anda</span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($matchedCandidates as $candidate)
                            <div class="list-group-item p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <a href="{{ route('company.candidates.show', $candidate->id) }}" class="fw-bold text-dark text-decoration-none fs-5 d-block mb-1">{{ $candidate->full_name }}</a>
                                        <span class="text-muted small">{{ $candidate->headline ?? 'Pencari Kerja' }}</span>
                                    </div>
                                    <div class="text-end">
                                        <div class="fs-4 fw-bold text-success">{{ $candidate->match_score }}%</div>
                                        <span class="text-muted small">Kecocokan</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex flex-wrap gap-2 text-muted small">
                                        <span class="border rounded px-2 py-0.5 bg-light">📍 {{ $candidate->location ?? 'N/A' }}</span>
                                        <span class="border rounded px-2 py-0.5 bg-light">💼 {{ $candidate->experience_years }} Thn Pengalaman</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        @php
                                            $jobSkillIds = $jobPosting->skills->pluck('id')->toArray();
                                        @endphp
                                        @foreach($candidate->skills as $skill)
                                            <span class="badge @if(in_array($skill->id, $jobSkillIds)) bg-success text-white @else bg-light text-muted @endif py-1 px-2 rounded-pill small">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="text-end">
                                    <span class="small text-muted block-inline mb-2 d-block">Ingin merekrut kandidat ini?</span>
                                    <a href="mailto:admin@agency.com?subject=Permintaan Penyaluran Kerja: {{ $candidate->full_name }} - {{ $jobPosting->title }}&body=Halo Admin, kami berminat menyalurkan kandidat {{ $candidate->full_name }} untuk lowongan kami ({{ $jobPosting->title }}). Mohon bantu hubungkan." class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">Hubungi Admin Agen</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                Tidak ada rekomendasi kandidat saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
