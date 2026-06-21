@extends('layouts.layouts')

@section('content')
<div class="container" style="max-width: 800px;">
    <!-- Navigation -->
    <div class="mb-4">
        <a href="{{ route('company.job-postings.index') }}" class="btn btn-link text-decoration-none p-0 fw-bold">← Kembali ke Lowongan Kerja Saya</a>
        <h1 class="fw-bold text-dark mt-2 mb-1">Edit Lowongan Pekerjaan</h1>
        <p class="text-muted">Perbarui data kualifikasi lowongan pekerjaan</p>
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

    <form action="{{ route('company.job-postings.update', $jobPosting->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Detail Lowongan -->
        <div class="card shadow-sm border-0 mb-4 bg-white">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="fw-bold mb-0 text-dark">📋 Rincian Lowongan</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Judul Posisi Lowongan <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $jobPosting->title) }}" placeholder="Contoh: Flutter Developer / Staf Admin" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Lokasi Penempatan</label>
                        <input type="text" name="location" value="{{ old('location', $jobPosting->location) }}" placeholder="Contoh: Jakarta Pusat, Remote" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="open" {{ old('status', $jobPosting->status) === 'open' ? 'selected' : '' }}>Buka (Open)</option>
                            <option value="closed" {{ old('status', $jobPosting->status) === 'closed' ? 'selected' : '' }}>Tutup (Closed)</option>
                            <option value="filled" {{ old('status', $jobPosting->status) === 'filled' ? 'selected' : '' }}>Terisi (Filled)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Minimum Gaji (Rp)</label>
                        <input type="number" name="salary_min" value="{{ old('salary_min', $jobPosting->salary_min ? (int)$jobPosting->salary_min : '') }}" placeholder="Contoh: 4000000" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Maksimum Gaji (Rp)</label>
                        <input type="number" name="salary_max" value="{{ old('salary_max', $jobPosting->salary_max ? (int)$jobPosting->salary_max : '') }}" placeholder="Contoh: 6000000" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted">Deskripsi Pekerjaan & Kualifikasi</label>
                        <textarea name="description" rows="5" placeholder="Tuliskan deskripsi pekerjaan, tanggung jawab, dan kualifikasi yang diinginkan..." class="form-control">{{ old('description', $jobPosting->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Persyaratan Pelamar -->
        <div class="card shadow-sm border-0 mb-4 bg-white">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="fw-bold mb-0 text-dark">🎓 Persyaratan Kriteria</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Minimal Tingkat Pendidikan</label>
                        <select name="education_requirement" class="form-select">
                            <option value="">Semua Pendidikan</option>
                            <option value="SMA" {{ old('education_requirement', $jobPosting->education_requirement) === 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                            <option value="SMK" {{ old('education_requirement', $jobPosting->education_requirement) === 'SMK' ? 'selected' : '' }}>SMK</option>
                            <option value="D3" {{ old('education_requirement', $jobPosting->education_requirement) === 'D3' ? 'selected' : '' }}>DIPLOMA 3 (D3)</option>
                            <option value="S1" {{ old('education_requirement', $jobPosting->education_requirement) === 'S1' ? 'selected' : '' }}>SARJANA 1 (S1)</option>
                            <option value="S2" {{ old('education_requirement', $jobPosting->education_requirement) === 'S2' ? 'selected' : '' }}>PASCA SARJANA (S2)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Minimal Pengalaman Kerja (Tahun)</label>
                        <input type="number" name="experience_years" value="{{ old('experience_years', $jobPosting->experience_years) }}" placeholder="Contoh: 2" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <!-- Skills required checkboxes -->
        <div class="card shadow-sm border-0 mb-4 bg-white">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="fw-bold mb-0 text-dark">⚡ Keahlian yang Dibutuhkan</h5>
            </div>
            <div class="card-body">
                <label class="form-label small fw-semibold text-muted d-block mb-3">Pilih keahlian khusus yang harus dimiliki pelamar:</label>
                <div class="row g-2">
                    @php
                        $jobSkills = $jobPosting->skills->pluck('id')->toArray();
                    @endphp
                    @foreach($skills as $skill)
                        <div class="col-md-4 col-sm-6">
                            <div class="form-check p-2 border rounded shadow-sm bg-white d-flex align-items-center">
                                <input class="form-check-input ms-1 me-2" type="checkbox" name="skills[]" value="{{ $skill->id }}" id="skill-{{ $skill->id }}" {{ in_array($skill->id, old('skills', $jobSkills)) ? 'checked' : '' }}>
                                <label class="form-check-label text-dark small" for="skill-{{ $skill->id }}">
                                    {{ $skill->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="mb-5 d-flex gap-2">
            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold py-2.5">Perbarui Lowongan Kerja</button>
            <a href="{{ route('company.job-postings.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold py-2.5">Batal</a>
        </div>
    </form>
</div>
@endsection
