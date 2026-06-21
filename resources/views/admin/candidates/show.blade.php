@extends('layouts.layouts')

@section('content')
<div class="container" style="max-width: 900px;">
    <!-- Navigation -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.candidates.index') }}" class="btn btn-link text-decoration-none p-0 fw-bold">← Kembali ke Daftar Kandidat</a>
        <div>
            <a href="{{ route('admin.candidates.edit', $candidate->id) }}" class="btn btn-primary rounded-pill px-4 fw-bold">Edit Profil</a>
        </div>
    </div>

    <!-- Candidate Profile Card -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; font-size: 3rem;">
                        {{ $candidate->gender === 'Perempuan' ? '👩' : '👨' }}
                    </div>
                </div>
                <div class="col-md-7 text-center text-md-start">
                    <h2 class="fw-bold mb-1">{{ $candidate->full_name }}</h2>
                    <p class="text-primary fw-semibold mb-2">{{ $candidate->headline ?? 'Pencari Kerja' }}</p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 text-muted small">
                        <span>📍 {{ $candidate->location ?? 'Lokasi tidak dispesifikasikan' }}</span>
                        <span>💰 Ekspektasi Gaji: {{ $candidate->expected_salary ?? 'Nego' }}</span>
                        <span>⏱️ {{ $candidate->availability ?? 'Tersedia segera' }}</span>
                    </div>
                </div>
                <div class="col-md-3 text-center text-md-end mt-3 mt-md-0">
                    <span class="badge @if($candidate->status === 'tersedia') bg-success @elseif($candidate->status === 'disalurkan') bg-primary @else bg-danger @endif px-4 py-2 rounded-pill fs-6 text-capitalize">
                        {{ $candidate->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Details -->
        <div class="col-md-8">
            <!-- About Me -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">📋 Tentang Diri</h5>
                </div>
                <div class="card-body">
                    <p class="text-secondary" style="white-space: pre-line;">{{ $candidate->about ?? 'Belum ada deskripsi tentang diri.' }}</p>
                </div>
            </div>

            <!-- Experience -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">💼 Riwayat Pekerjaan</h5>
                </div>
                <div class="card-body">
                    @forelse($candidate->experiences as $exp)
                        <div class="mb-4 border-start border-3 border-primary ps-3 pb-1">
                            <h6 class="fw-bold mb-1 text-dark">{{ $exp->position }}</h6>
                            <div class="text-primary small fw-semibold mb-2">{{ $exp->company }}</div>
                            <div class="text-muted small mb-2">
                                📅 {{ \Carbon\Carbon::parse($exp->start_date)->translatedFormat('M Y') }} — 
                                {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->translatedFormat('M Y') : 'Sekarang' }}
                            </div>
                            @if($exp->description)
                                <p class="text-muted small mb-0">{{ $exp->description }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada riwayat pekerjaan yang ditambahkan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Education -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">🎓 Riwayat Pendidikan</h5>
                </div>
                <div class="card-body">
                    @forelse($candidate->educations as $edu)
                        <div class="mb-4 border-start border-3 border-secondary ps-3 pb-1">
                            <h6 class="fw-bold mb-1 text-dark">{{ $edu->degree }}</h6>
                            <div class="text-secondary small fw-semibold mb-2">{{ $edu->institution }}</div>
                            <div class="text-muted small mb-0">
                                📅 Tahun Masuk: {{ $edu->start_year }} — Lulus: {{ $edu->end_year ?? 'Belum Lulus' }}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada riwayat pendidikan yang ditambahkan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Placements history -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">🚀 Riwayat Penyaluran Kerja</h5>
                </div>
                <div class="card-body">
                    @forelse($candidate->placements as $placement)
                        <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $placement->jobPosting->title }}</h6>
                                <p class="text-muted small mb-1">{{ $placement->jobPosting->company->name }}</p>
                                <span class="text-muted small">
                                    Penyaluran: {{ $placement->created_at->format('d M Y') }}
                                </span>
                                @if($placement->notes)
                                    <div class="text-muted small mt-2 bg-light p-2 rounded">
                                        <strong>Catatan:</strong> {{ $placement->notes }}
                                    </div>
                                @endif
                            </div>
                            <span class="badge @if($placement->status === 'pending') bg-warning text-dark @elseif($placement->status === 'accepted') bg-success @elseif($placement->status === 'completed') bg-primary @else bg-danger @endif px-3 py-1.5 rounded-pill text-capitalize">
                                {{ $placement->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Kandidat ini belum memiliki riwayat penempatan kerja.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Contact & Skills -->
        <div class="col-md-4">
            <!-- Contact Info -->
            <div class="card shadow-sm border-0 mb-4 bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-dark">📞 Informasi Kontak</h5>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Email</label>
                        <div class="text-dark fw-medium">{{ $candidate->email ?? 'Tidak ada data email' }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-1">No. Telepon</label>
                        <div class="text-dark fw-medium">{{ $candidate->phone ?? 'Tidak ada data telepon' }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Tanggal Lahir</label>
                        <div class="text-dark fw-medium">
                            {{ $candidate->date_of_birth ? $candidate->date_of_birth->format('d M Y') : '-' }}
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted mb-1">Jenis Kelamin</label>
                        <div class="text-dark fw-medium">{{ $candidate->gender ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Skills List -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">⚡ Keahlian (Skills)</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($candidate->skills as $skill)
                            <span class="badge bg-light text-primary border border-primary-subtle py-2 px-3 rounded-pill text-dark">{{ $skill->name }}</span>
                        @empty
                            <span class="text-muted small">Tidak ada keahlian khusus terdaftar.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
