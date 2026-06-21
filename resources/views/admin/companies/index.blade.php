@extends('layouts.layouts')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1">Daftar Perusahaan</h1>
            <p class="text-muted mb-0">Kelola pendaftaran dan data profil semua perusahaan mitra</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs Filtering -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body py-2">
            <ul class="nav nav-pills gap-2 small">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === null ? 'active fw-bold' : '' }}" href="{{ route('admin.companies.index') }}">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'pending' ? 'active fw-bold' : '' }}" href="{{ route('admin.companies.index', ['status' => 'pending']) }}">Menunggu Verifikasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'verified' ? 'active fw-bold' : '' }}" href="{{ route('admin.companies.index', ['status' => 'verified']) }}">Terverifikasi</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Perusahaan</th>
                            <th>Industri</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Status Verifikasi</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies as $company)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $company->name }}</div>
                                    <div class="text-muted small">PIC: {{ $company->contact_person ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary py-1.5 px-3 rounded-pill">{{ $company->industry ?? '-' }}</span>
                                </td>
                                <td>{{ $company->email ?? $company->user->email }}</td>
                                <td>{{ $company->phone ?? '-' }}</td>
                                <td>
                                    @if($company->user->verified_at)
                                        <span class="badge bg-success py-1.5 px-3 rounded-pill">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-warning text-dark py-1.5 px-3 rounded-pill">Menunggu Verifikasi</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.companies.show', $company->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-bold">Detail</a>

                                    @if(!$company->user->verified_at)
                                        <form action="{{ route('admin.companies.verify', $company->id) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            <button class="btn btn-sm btn-success px-3 rounded-pill fw-bold">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.companies.reject', $company->id) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger px-3 rounded-pill fw-bold" onclick="return confirm('Tolak pendaftaran ini?')">Tolak</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST" class="d-inline ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger px-3 rounded-pill fw-bold" onclick="return confirm('Hapus perusahaan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Tidak ada data perusahaan yang cocok dengan kriteria status ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($companies->hasPages())
            <div class="card-footer bg-transparent border-top py-3">
                {{ $companies->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
