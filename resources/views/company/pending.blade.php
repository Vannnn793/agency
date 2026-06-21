@extends('layouts.layouts')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 60vh;">
    <div class="card shadow border-0 p-5 text-center bg-white" style="max-width: 600px; border-radius: 16px;">
        <div class="fs-1 mb-3">🕒</div>
        <h2 class="fw-bold text-dark mb-3">Pendaftaran Menunggu Verifikasi</h2>
        <p class="text-secondary leading-relaxed mb-4">
            Terima kasih telah mendaftarkan perusahaan Anda. Saat ini akun Anda sedang dalam antrean proses verifikasi oleh Administrator. 
        </p>
        <div class="alert alert-info border-0 py-2.5 px-4 mb-4 small text-start">
            💡 <strong>Informasi:</strong> Setelah akun Anda diverifikasi, Anda akan mendapatkan akses penuh untuk mempublikasikan lowongan pekerjaan dan melihat data kandidat yang cocok.
        </div>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('company.pending') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Refresh Halaman</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-danger rounded-pill px-4 fw-bold">Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection
