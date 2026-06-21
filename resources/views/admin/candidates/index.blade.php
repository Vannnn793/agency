@extends('layouts.layouts')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1">Daftar Kandidat</h1>
            <p class="text-muted mb-0">Kelola data semua pencari kerja yang disalurkan</p>
        </div>
        <a href="{{ route('admin.candidates.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">➕ Tambah Kandidat</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.candidates.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="disalurkan" {{ request('status') === 'disalurkan' ? 'selected' : '' }}>Disalurkan</option>
                        <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">Lokasi</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Cari kota..." class="form-select text-start bg-white">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted">Skill Utama</label>
                    <select name="skill" class="form-select">
                        <option value="">Semua Skill</option>
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

    <!-- Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Lengkap</th>
                            <th>Kontak</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Keahlian (Skills)</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $candidate)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $candidate->full_name }}</div>
                                    <div class="text-muted small">{{ $candidate->headline ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="small text-dark">{{ $candidate->email ?? 'No Email' }}</div>
                                    <div class="small text-muted">{{ $candidate->phone ?? '-' }}</div>
                                </td>
                                <td>{{ $candidate->location ?? 'Remote' }}</td>
                                <td>
                                    <span class="badge @if($candidate->status === 'tersedia') bg-success @elseif($candidate->status === 'disalurkan') bg-primary @else bg-danger @endif px-3 py-1.5 rounded-pill text-capitalize">{{ $candidate->status }}</span>
                                </td>
                                <td>
                                    @forelse($candidate->skills as $skill)
                                        <span class="badge bg-light text-primary border border-primary-subtle py-1 px-2.5 rounded-pill mb-1 small">{{ $skill->name }}</span>
                                    @empty
                                        <span class="text-muted small">-</span>
                                    @endforelse
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-bold">Detail</a>
                                    <a href="{{ route('admin.candidates.edit', $candidate->id) }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill fw-bold ms-1">Edit</a>
                                    <form action="{{ route('admin.candidates.destroy', $candidate->id) }}" method="POST" class="d-inline ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger px-3 rounded-pill fw-bold" onclick="return confirm('Hapus data kandidat ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Tidak ada data kandidat yang cocok dengan kriteria filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($candidates->hasPages())
            <div class="card-footer bg-transparent border-top py-3">
                {{ $candidates->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection