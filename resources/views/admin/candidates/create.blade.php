@extends('layouts.layouts')

@section('content')
<div class="container" style="max-width: 900px;">
    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('admin.candidates.index') }}" class="btn btn-link text-decoration-none p-0 fw-bold">← Kembali ke Daftar Kandidat</a>
        <h1 class="fw-bold text-dark mt-2 mb-1">Tambah Kandidat Baru</h1>
        <p class="text-muted">Masukkan data profil lengkap kandidat pelamar</p>
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

    <form action="{{ route('admin.candidates.store') }}" method="POST">
        @csrf

        <!-- 1. DATA PRIBADI -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="fw-bold mb-0 text-dark">👤 Informasi Pribadi</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Nama lengkap kandidat" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Status Ketersediaan <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="disalurkan" {{ old('status') === 'disalurkan' ? 'selected' : '' }}>Disalurkan</option>
                            <option value="tidak_aktif" {{ old('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">No. Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 0812xxxxxxxx" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama.kandidat@domain.com" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Jenis Kelamin</label>
                        <select name="gender" class="form-select">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. PROFIL PROFESIONAL -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="fw-bold mb-0 text-dark">💼 Profil Profesional</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label small fw-semibold text-muted">Headline Profesional</label>
                        <input type="text" name="headline" value="{{ old('headline') }}" placeholder="Contoh: Senior Web Developer / Administrasi Perkantoran" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Lokasi Tinggal Sekarang</label>
                        <input type="text" name="location" value="{{ old('location') }}" placeholder="Contoh: Jakarta Selatan, Surabaya" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Gaji yang Diharapkan (Rp)</label>
                        <input type="text" name="expected_salary" value="{{ old('expected_salary') }}" placeholder="Contoh: 5.000.000 / Nego" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Ketersediaan Waktu Kerja</label>
                        <input type="text" name="availability" value="{{ old('availability') }}" placeholder="Contoh: Segera / Pemberitahuan 1 Bulan" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted">Tentang / Deskripsi Diri</label>
                        <textarea name="about" rows="3" placeholder="Ceritakan ringkasan keahlian dan profil kandidat..." class="form-control">{{ old('about') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. SKILLS -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="fw-bold mb-0 text-dark">⚡ Keahlian (Skills)</h5>
            </div>
            <div class="card-body">
                <label class="form-label small fw-semibold text-muted d-block mb-3">Pilih keahlian yang dikuasai kandidat:</label>
                <div class="row g-2">
                    @foreach($skills as $skill)
                        <div class="col-md-4 col-sm-6">
                            <div class="form-check p-2 border rounded shadow-sm bg-white d-flex align-items-center">
                                <input class="form-check-input ms-1 me-2" type="checkbox" name="skills[]" value="{{ $skill->id }}" id="skill-{{ $skill->id }}" {{ is_array(old('skills')) && in_array($skill->id, old('skills')) ? 'checked' : '' }}>
                                <label class="form-check-label text-dark small" for="skill-{{ $skill->id }}">
                                    {{ $skill->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 4. RIWAYAT PEKERJAAN (DYNAMIC) -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">🏢 Riwayat Pengalaman Kerja</h5>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill fw-bold" id="add-experience">➕ Tambah Pengalaman</button>
            </div>
            <div class="card-body">
                <div id="experience-list">
                    <!-- Dynamic fields added via JS -->
                </div>
            </div>
        </div>

        <!-- 5. RIWAYAT PENDIDIKAN (DYNAMIC) -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">🎓 Riwayat Pendidikan</h5>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill fw-bold" id="add-education">➕ Tambah Pendidikan</button>
            </div>
            <div class="card-body">
                <div id="education-list">
                    <!-- Dynamic fields added via JS -->
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mb-5 d-flex gap-2">
            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold py-2.5">Simpan Data Kandidat</button>
            <a href="{{ route('admin.candidates.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold py-2.5">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Dinamis Pengalaman
    const addExperienceBtn = document.getElementById('add-experience');
    const experienceList = document.getElementById('experience-list');

    addExperienceBtn.addEventListener('click', () => {
        const itemIndex = experienceList.children.length;
        const row = document.createElement('div');
        row.className = 'border-bottom pb-3 mb-3 experience-row';
        row.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Posisi / Jabatan</label>
                    <input type="text" name="exp_position[]" placeholder="Contoh: Staf Admin" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Nama Perusahaan</label>
                    <input type="text" name="exp_company[]" placeholder="Contoh: PT. Abadi" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Tanggal Mulai</label>
                    <input type="date" name="exp_start_date[]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Tanggal Selesai (Kosongkan jika masih bekerja)</label>
                    <input type="date" name="exp_end_date[]" class="form-control form-control-sm">
                </div>
                <div class="col-md-12">
                    <label class="form-label small fw-semibold text-muted">Deskripsi Tugas</label>
                    <textarea name="exp_description[]" rows="2" placeholder="Tuliskan detail pekerjaan..." class="form-control form-control-sm"></textarea>
                </div>
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger py-1 px-3 rounded-pill remove-row-btn">Hapus Baris</button>
                </div>
            </div>
        `;
        experienceList.appendChild(row);
    });

    // Dinamis Pendidikan
    const addEducationBtn = document.getElementById('add-education');
    const educationList = document.getElementById('education-list');

    addEducationBtn.addEventListener('click', () => {
        const itemIndex = educationList.children.length;
        const row = document.createElement('div');
        row.className = 'border-bottom pb-3 mb-3 education-row';
        row.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Institusi Pendidikan</label>
                    <input type="text" name="edu_institution[]" placeholder="Contoh: Universitas Indonesia" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Gelar / Bidang Studi</label>
                    <input type="text" name="edu_degree[]" placeholder="Contoh: S1 Akuntansi / SMA IPA" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Tahun Masuk</label>
                    <input type="number" name="edu_start_year[]" placeholder="Contoh: 2018" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Tahun Lulus (Kosongkan jika belum lulus)</label>
                    <input type="number" name="edu_end_year[]" placeholder="Contoh: 2022" class="form-control form-control-sm">
                </div>
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger py-1 px-3 rounded-pill remove-row-btn">Hapus Baris</button>
                </div>
            </div>
        `;
        educationList.appendChild(row);
    });

    // Event listener untuk menghapus baris pengalaman/pendidikan
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-row-btn')) {
            e.target.closest('.experience-row, .education-row').remove();
        }
    });
</script>
@endpush
