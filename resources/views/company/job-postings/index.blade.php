@extends('layouts.layouts')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1">Lowongan Kerja Saya</h1>
            <p class="text-muted mb-0">Kelola dan pantau lowongan pekerjaan yang Anda publikasikan</p>
        </div>
        <a href="{{ route('company.job-postings.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">➕ Publikasikan Lowongan</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body py-3">
            <form action="{{ route('company.job-postings.index') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold text-muted">Status Lowongan</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Buka (Open)</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Tutup (Closed)</option>
                        <option value="filled" {{ request('status') === 'filled' ? 'selected' : '' }}>Terisi (Filled)</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-outline-secondary w-100 rounded-pill fw-bold">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0 bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Lowongan Kerja</th>
                            <th>Lokasi</th>
                            <th>Rentang Gaji</th>
                            <th>Status</th>
                            <th>Keahlian Diminta</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobPostings as $job)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark mb-0">{{ $job->title }}</div>
                                    <div class="text-muted small">Syarat Pengalaman: {{ $job->experience_years ? $job->experience_years . ' tahun' : 'Fresh Graduate' }}</div>
                                </td>
                                <td>{{ $job->location ?? 'Remote' }}</td>
                                <td>
                                    @if($job->salary_min || $job->salary_max)
                                        <div class="small">
                                            {{ $job->salary_min ? 'Rp ' . number_format($job->salary_min, 0, ',', '.') : '-' }} 
                                            s/d 
                                            {{ $job->salary_max ? 'Rp ' . number_format($job->salary_max, 0, ',', '.') : '-' }}
                                        </div>
                                    @else
                                        <div class="small text-muted">-</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge @if($job->status === 'open') bg-success @elseif($job->status === 'closed') bg-secondary @else bg-info text-dark @endif py-1.5 px-3 rounded-pill text-capitalize">
                                        {{ $job->status }}
                                    </span>
                                </td>
                                <td>
                                    @forelse($job->skills as $skill)
                                        <span class="badge bg-light text-primary border border-primary-subtle py-1 px-2.5 rounded-pill mb-1 small">{{ $skill->name }}</span>
                                    @empty
                                        <span class="text-muted small">-</span>
                                    @endforelse
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('company.job-postings.show', $job->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-bold">Detail / Rekomendasi</a>
                                    <a href="{{ route('company.job-postings.edit', $job->id) }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill fw-bold ms-1">Edit</a>
                                    <form action="{{ route('company.job-postings.destroy', $job->id) }}" method="POST" class="d-inline ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger px-3 rounded-pill fw-bold" onclick="return confirm('Hapus lowongan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Anda belum menerbitkan lowongan pekerjaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($jobPostings->hasPages())
            <div class="card-footer bg-transparent border-top py-3">
                {{ $jobPostings->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
