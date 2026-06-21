@extends('layouts.layouts')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-1">Cari Pelamar</h1>
        <p class="text-muted mb-0">Temukan pelamar kerja terdaftar yang siap disalurkan ke perusahaan Anda</p>
    </div>

    <!-- Search / Filter Card -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body">
            <form action="{{ route('company.candidates.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted">Lokasi</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Cari kota tempat tinggal..." class="form-control text-start bg-white">
                </div>
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted">Keahlian (Skills)</label>
                    <select name="skill" class="form-select">
                        <option value="">Semua Keahlian</option>
                        @foreach($skills as $skill)
                            <option value="{{ $skill->id }}" {{ request('skill') == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-secondary w-100 rounded-pill fw-bold">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Candidates Grid -->
    <div class="row g-4 mb-5">
        @forelse($candidates as $candidate)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 h-100 bg-white">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 text-secondary" style="width: 60px; height: 60px; font-size: 1.8rem;">
                                {{ $candidate->gender === 'Perempuan' ? '👩' : '👨' }}
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">{{ $candidate->full_name }}</h5>
                                <span class="text-primary small fw-semibold">{{ $candidate->headline ?? 'Pencari Kerja' }}</span>
                            </div>
                        </div>

                        <div class="text-muted small mb-3 flex-grow-1">
                            <div class="mb-1">📍 <strong>Lokasi:</strong> {{ $candidate->location ?? 'Remote' }}</div>
                            <div class="mb-1">💰 <strong>Ekspektasi Gaji:</strong> {{ $candidate->expected_salary ?? 'Nego' }}</div>
                            <div class="mb-1">⏱️ <strong>Ketersediaan:</strong> {{ $candidate->availability ?? 'Segera' }}</div>
                            <div class="mb-0">💼 <strong>Pengalaman:</strong> {{ $candidate->experience_years }} Tahun</div>
                        </div>

                        <!-- Skill Tags -->
                        <div class="mb-4">
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($candidate->skills as $skill)
                                    <span class="badge bg-light text-primary border border-primary-subtle py-1 px-2 rounded-pill small">{{ $skill->name }}</span>
                                @empty
                                    <span class="text-muted small">-</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="mt-auto">
                            <a href="{{ route('company.candidates.show', $candidate->id) }}" class="btn btn-outline-primary w-100 rounded-pill fw-bold py-2">Lihat Detail Profil</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm border-0 py-5 text-center bg-white text-muted">
                    Tidak ada kandidat siap kerja yang cocok dengan pencarian Anda saat ini.
                </div>
            </div>
        @endforelse
    </div>

    @if($candidates->hasPages())
        <div class="d-flex justify-content-center">
            {{ $candidates->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
