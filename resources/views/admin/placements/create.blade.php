@extends('layouts.layouts')

@section('content')
<div class="container" style="max-width: 700px;">
    <!-- Navigation -->
    <div class="mb-4">
        <a href="{{ route('admin.placements.index') }}" class="btn btn-link text-decoration-none p-0 fw-bold">← Kembali ke Daftar Penyaluran</a>
        <h1 class="fw-bold text-dark mt-2 mb-1">Jadwalkan Penyaluran Kerja</h1>
        <p class="text-muted">Hubungkan kandidat pencari kerja dengan lowongan yang tersedia</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0 px-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.placements.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm border-0 bg-white mb-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="fw-bold mb-0 text-dark">📋 Formulir Penyaluran</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Candidate selection -->
                    <div class="col-md-12">
                        <label class="form-label small fw-semibold text-muted">Kandidat Pelamar (Hanya Status Tersedia) <span class="text-danger">*</span></label>
                        <select name="candidate_id" class="form-select select2-enable" required>
                            <option value="">Pilih Kandidat Pelamar</option>
                            @foreach($candidates as $candidate)
                                <option value="{{ $candidate->id }}" {{ old('candidate_id', $selected_candidate) == $candidate->id ? 'selected' : '' }}>
                                    {{ $candidate->full_name }} ({{ $candidate->headline ?? 'Kandidat' }} - {{ $candidate->location ?? 'No Location' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Job Posting selection -->
                    <div class="col-md-12">
                        <label class="form-label small fw-semibold text-muted">Lowongan Pekerjaan (Hanya Lowongan Aktif) <span class="text-danger">*</span></label>
                        <select name="job_posting_id" class="form-select select2-enable" required>
                            <option value="">Pilih Lowongan Kerja</option>
                            @foreach($jobPostings as $job)
                                <option value="{{ $job->id }}" {{ old('job_posting_id', $selected_job) == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }} di {{ $job->company->name }} ({{ $job->location ?? 'Remote' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="col-md-12">
                        <label class="form-label small fw-semibold text-muted">Catatan Penyaluran</label>
                        <textarea name="notes" rows="4" placeholder="Tuliskan jadwal wawancara, catatan penyerahan berkas, atau detail lainnya..." class="form-control">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="mb-5 d-flex gap-2">
            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold py-2.5">Jadwalkan Penyaluran</button>
            <a href="{{ route('admin.placements.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold py-2.5">Batal</a>
        </div>
    </form>
</div>
@endsection
