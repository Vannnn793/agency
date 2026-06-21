@extends('layouts.layouts')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1">Manajemen Skills</h1>
            <p class="text-muted mb-0">Kelola daftar kualifikasi keahlian yang digunakan dalam pencocokan sistem</p>
        </div>
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

    <div class="row g-4">
        <!-- List of skills -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 bg-white h-100">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">📋 Daftar Keahlian</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Keahlian</th>
                                    <th>Kandidat Memiliki</th>
                                    <th>Lowongan Meminta</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($skills as $skill)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $skill->name }}</td>
                                        <td>
                                            <span class="badge bg-light text-primary border py-1.5 px-3 rounded-pill fw-semibold">{{ $skill->candidates_count }} orang</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-secondary border py-1.5 px-3 rounded-pill fw-semibold">{{ $skill->job_postings_count }} lowongan</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger px-3 rounded-pill fw-bold" onclick="return confirm('Hapus keahlian ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">Belum ada keahlian terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add new skill form -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">➕ Tambah Keahlian Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.skills.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted">Nama Keahlian <span class="text-danger">*</span></label>
                            <input type="text" name="name" placeholder="Contoh: Flutter, UI/UX Design, Data Entry" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Simpan Keahlian</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
