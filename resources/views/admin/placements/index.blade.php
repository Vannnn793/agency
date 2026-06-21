@extends('layouts.layouts')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1">Penyaluran Kerja (Placements)</h1>
            <p class="text-muted mb-0">Kelola dan pantau proses penyaluran kandidat ke lowongan kerja</p>
        </div>
        <a href="{{ route('admin.placements.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">➕ Jadwalkan Penyaluran</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0 small">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body">
            <form action="{{ route('admin.placements.index') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold text-muted">Filter Status Penyaluran</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Tertunda (Pending)</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Diterima (Accepted)</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai Kontrak (Completed)</option>
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
                            <th class="ps-4">Kandidat</th>
                            <th>Posisi Lowongan</th>
                            <th>Perusahaan</th>
                            <th>Tgl Dijadwalkan</th>
                            <th>Status</th>
                            <th>Aksi Update Status</th>
                            <th class="text-end pe-4">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($placements as $placement)
                            <tr>
                                <td class="ps-4">
                                    <a href="{{ route('admin.candidates.show', $placement->candidate->id) }}" class="fw-bold text-dark text-decoration-none d-block mb-0">{{ $placement->candidate->full_name }}</a>
                                    <span class="text-muted small">{{ $placement->candidate->phone ?? '-' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.job-postings.show', $placement->jobPosting->id) }}" class="fw-semibold text-secondary text-decoration-none">{{ $placement->jobPosting->title }}</a>
                                </td>
                                <td>{{ $placement->jobPosting->company->name }}</td>
                                <td>
                                    <div class="small">{{ $placement->created_at->format('d M Y') }}</div>
                                    @if($placement->placed_at)
                                        <div class="small text-success">Ditempatkan: {{ $placement->placed_at->format('d M Y') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge @if($placement->status === 'pending') bg-warning text-dark @elseif($placement->status === 'accepted') bg-success @elseif($placement->status === 'completed') bg-primary @else bg-danger @endif py-1.5 px-3 rounded-pill text-capitalize">
                                        {{ $placement->status }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.placements.status', $placement->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm rounded-pill" style="width: 130px;" onchange="this.form.submit()">
                                            <option value="pending" {{ $placement->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="accepted" {{ $placement->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="rejected" {{ $placement->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="completed" {{ $placement->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        @if($placement->notes)
                                            <span class="text-muted small cursor-pointer" title="{{ $placement->notes }}">💬 Note</span>
                                        @endif
                                    </form>
                                    <button type="button" class="btn btn-link text-decoration-none p-0 small text-secondary mt-1" data-bs-toggle="collapse" data-bs-target="#note-collapse-{{ $placement->id }}">
                                        Edit Catatan
                                    </button>
                                    <div class="collapse mt-2" id="note-collapse-{{ $placement->id }}">
                                        <form action="{{ route('admin.placements.status', $placement->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="{{ $placement->status }}">
                                            <textarea name="notes" placeholder="Tulis catatan..." class="form-control form-control-sm mb-1">{{ $placement->notes }}</textarea>
                                            <button class="btn btn-sm btn-primary rounded-pill py-0.5 px-3 small fw-bold">Simpan</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.placements.destroy', $placement->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger px-3 rounded-pill fw-bold" onclick="return confirm('Batalkan penyaluran ini?')">Batal</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Tidak ada data penyaluran kerja terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($placements->hasPages())
            <div class="card-footer bg-transparent border-top py-3">
                {{ $placements->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
