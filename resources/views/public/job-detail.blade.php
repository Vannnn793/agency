@extends('layouts.public')

@section('title', $job->title)

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- JOB DETAILS -->
            <div class="col-lg-8">
                <!-- Back Button -->
                <a href="{{ route('public.jobs') }}" class="btn btn-link text-primary mb-4">
                    ← Kembali ke Lowongan Kerja
                </a>

                <div class="card p-5 mb-4">
                    <div class="mb-4">
                        <h1 class="fw-bold mb-2">{{ $job->title }}</h1>
                        <p class="text-muted mb-3">
                            <strong class="text-dark">{{ $job->company->name }}</strong> • 📍 {{ $job->location }}
                        </p>
                        <p class="text-muted">
                            ⏰ Dibuka sejak {{ $job->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <!-- Salary -->
                    @if($job->salary_min && $job->salary_max)
                        <div class="alert alert-light border border-primary mb-4" style="background: #f0f9ff;">
                            <h5 class="text-primary fw-bold mb-2">💰 Gaji</h5>
                            <p class="mb-0">
                                <strong>Rp {{ number_format($job->salary_min, 0, ',', '.') }} - Rp {{ number_format($job->salary_max, 0, ',', '.') }} / bulan</strong>
                            </p>
                        </div>
                    @endif

                    <!-- Job Info Grid -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">📚 Pendidikan</h6>
                            <p class="fw-bold">{{ $job->education_requirement ?? 'Tidak dispesifikkan' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">💼 Pengalaman</h6>
                            <p class="fw-bold">{{ $job->experience_years ? $job->experience_years . ' tahun' : 'Fresh Graduate' }}</p>
                        </div>
                    </div>

                    <!-- Skills Required -->
                    @if($job->skills->isNotEmpty())
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">🎯 Skills yang Diperlukan</h5>
                            <div>
                                @foreach($job->skills as $skill)
                                    <span class="badge-skill">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Job Description -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">📝 Deskripsi Pekerjaan</h5>
                        <div class="text-muted" style="line-height: 1.8;">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Company Info -->
                    <div class="alert alert-light border p-4 mb-0">
                        <h5 class="fw-bold mb-3">🏢 Tentang Perusahaan</h5>
                        <p class="mb-2"><strong>{{ $job->company->name }}</strong></p>
                        @if($job->company->industry)
                            <p class="text-muted mb-2">🏭 Industri: {{ $job->company->industry }}</p>
                        @endif
                        @if($job->company->description)
                            <p class="text-muted mb-0">{{ Str::limit($job->company->description, 200) }}</p>
                        @endif
                        @if($job->company->address)
                            <p class="text-muted mb-0">📍 {{ $job->company->address }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
                <div class="card p-4 sticky-top" style="top: 20px;">
                    <div class="text-center mb-4">
                        <h6 class="text-muted mb-3">Tertarik dengan lowongan ini?</h6>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg w-100 mb-3">
                            📝 Lamar Sekarang
                        </a>
                        <p class="small text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold">Daftar di sini</a></p>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">ℹ️ Informasi Lowongan</h6>
                        <table class="w-100" style="font-size: 0.9rem;">
                            <tr class="mb-2">
                                <td class="text-muted pb-2">Status:</td>
                                <td class="fw-bold pb-2">
                                    <span class="badge bg-success text-white">{{ ucfirst($job->status) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted pb-2">Lokasi:</td>
                                <td class="fw-bold pb-2">{{ $job->location }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted pb-2">Diposting:</td>
                                <td class="fw-bold pb-2">{{ $job->created_at->diffForHumans() }}</td>
                            </tr>
                            @if($job->company->phone)
                                <tr>
                                    <td class="text-muted pb-2">Telepon:</td>
                                    <td class="fw-bold pb-2">{{ $job->company->phone }}</td>
                                </tr>
                            @endif
                            @if($job->company->email)
                                <tr>
                                    <td class="text-muted pb-2">Email:</td>
                                    <td class="fw-bold pb-2 text-break">{{ $job->company->email }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <hr>

                    <div>
                        <h6 class="fw-bold mb-3">💡 Tips</h6>
                        <ul class="list-unstyled small text-muted" style="line-height: 1.8;">
                            <li>✓ Lengkapi profil Anda sebelum melamar</li>
                            <li>✓ Pastikan skill Anda sesuai dengan yang dibutuhkan</li>
                            <li>✓ Siapkan CV yang menarik dan profesional</li>
                            <li>✓ Jangan lupa untuk follow up setelah melamar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- RELATED JOBS -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4">Lowongan Serupa Lainnya</h3>
            </div>
            @php
                $relatedJobs = \App\Models\JobPosting::where('status', 'open')
                    ->where('id', '!=', $job->id)
                    ->with('company', 'skills')
                    ->limit(3)
                    ->get();
            @endphp

            @forelse($relatedJobs as $relatedJob)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card job-card h-100 p-4">
                        <h6 class="card-title fw-bold mb-2">{{ $relatedJob->title }}</h6>
                        <p class="text-muted small mb-3">{{ $relatedJob->company->name }}</p>
                        
                        @if($relatedJob->salary_min && $relatedJob->salary_max)
                            <p class="text-primary fw-bold small mb-3">
                                Rp {{ number_format($relatedJob->salary_min, 0, ',', '.') }} - Rp {{ number_format($relatedJob->salary_max, 0, ',', '.') }}
                            </p>
                        @endif

                        <a href="{{ route('public.job-detail', $relatedJob->id) }}" class="btn btn-sm btn-primary mt-auto">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
@endsection
