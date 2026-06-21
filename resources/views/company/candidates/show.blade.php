@extends('layouts.layouts')

@section('content')
<div class="container" style="max-width: 900px;">
    <!-- Navigation -->
    <div class="mb-4">
        <a href="{{ route('company.candidates.index') }}" class="btn btn-link text-decoration-none p-0 fw-bold">← Kembali ke Pencarian Pelamar</a>
    </div>

    <!-- Profile Header Card -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto text-secondary" style="width: 100px; height: 100px; font-size: 3rem;">
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
                    <span class="badge bg-success px-4 py-2 rounded-pill fs-6 text-capitalize">Tersedia</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Details Column -->
        <div class="col-md-8">
            <!-- About Me -->
            <div class="card shadow-sm border-0 mb-4 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">📋 Ringkasan Profil</h5>
                </div>
                <div class="card-body">
                    <p class="text-secondary" style="white-space: pre-line;">{{ $candidate->about ?? 'Tidak ada deskripsi profil tambahan.' }}</p>
                </div>
            </div>

            <!-- Experience -->
            <div class="card shadow-sm border-0 mb-4 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">💼 Riwayat Pengalaman Kerja</h5>
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
                        <p class="text-muted mb-0">Tidak ada riwayat pekerjaan terdaftar.</p>
                    @endforelse
                </div>
            </div>

            <!-- Education -->
            <div class="card shadow-sm border-0 mb-4 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">🎓 Riwayat Pendidikan</h5>
                </div>
                <div class="card-body">
                    @forelse($candidate->educations as $edu)
                        <div class="mb-4 border-start border-3 border-secondary ps-3 pb-1">
                            <h6 class="fw-bold mb-1 text-dark">{{ $edu->degree }}</h6>
                            <div class="text-secondary small fw-semibold mb-2">{{ $edu->institution }}</div>
                            <div class="text-muted small mb-0">
                                📅 Tahun: {{ $edu->start_year }} — {{ $edu->end_year ?? 'Belum Lulus' }}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tidak ada riwayat pendidikan terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-md-4">
            <!-- Contact Request Callout -->
            <div class="card shadow-sm border-0 mb-4 bg-primary text-white" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">🤝 Tertarik Merekrut?</h5>
                    <p class="small opacity-90 mb-4">
                        Kandidat ini berada di bawah pengelolaan dan penyaluran AgenPekerjaan. Hubungi kami untuk mengatur jadwal wawancara kerja.
                    </p>
                    <a href="mailto:admin@agency.com?subject=Tanya Kandidat: {{ $candidate->full_name }}&body=Halo Admin, kami tertarik dengan profil {{ $candidate->full_name }}. Mohon bantu kami memproses." class="btn btn-light text-primary w-100 rounded-pill fw-bold py-2">Hubungi Admin Agensi</a>
                </div>
            </div>

            <!-- Skills -->
            <div class="card shadow-sm border-0 mb-4 bg-white">
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
