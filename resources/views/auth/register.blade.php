@extends('layouts.app')

@section('content')
<div class="auth-card" style="max-width: 550px;">
    <h2 class="fw-bold text-center text-primary mb-2">Registrasi Perusahaan</h2>
    <p class="text-muted text-center mb-4">Daftarkan perusahaan Anda untuk mencari pekerja terbaik</p>

    @if ($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0 px-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h5 class="fw-bold mb-3 border-bottom pb-1 text-secondary">Akun Pengguna</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label small mb-1 fw-semibold">Nama Perwakilan <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama perwakilan" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small mb-1 fw-semibold">Email Perusahaan <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@perusahaan.com" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label small mb-1 fw-semibold">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" placeholder="Password" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small mb-1 fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" class="form-control" required>
            </div>
        </div>

        <h5 class="fw-bold mb-3 border-bottom pb-1 text-secondary pt-2">Profil Perusahaan</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label small mb-1 fw-semibold">Nama Perusahaan <span class="text-danger">*</span></label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="PT. Maju Bersama" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small mb-1 fw-semibold">Industri / Sektor <span class="text-danger">*</span></label>
                <input type="text" name="industry" value="{{ old('industry') }}" placeholder="Teknologi, Keuangan, dll" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label small mb-1 fw-semibold">Telepon Perusahaan</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="021-xxxxxx" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label small mb-1 fw-semibold">Nama Kontak Person (PIC)</label>
                <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Nama PIC" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small mb-1 fw-semibold">Alamat Perusahaan</label>
            <textarea name="address" rows="2" placeholder="Alamat lengkap kantor" class="form-control">{{ old('address') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label small mb-1 fw-semibold">Deskripsi Singkat Perusahaan</label>
            <textarea name="description" rows="2" placeholder="Tentang perusahaan..." class="form-control">{{ old('description') }}</textarea>
        </div>

        <button class="btn btn-primary w-100 py-2 rounded-pill fw-bold">Daftar & Ajukan Verifikasi</button>
    </form>

    <p class="mt-3 text-center mb-0 small">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="fw-semibold">Masuk di sini</a>
    </p>
</div>
@endsection