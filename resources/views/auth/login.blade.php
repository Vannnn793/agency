@extends('layouts.app')

@section('content')
<div class="auth-card" style="max-width: 400px;">
    <h2 class="fw-bold text-center text-primary mb-2">Masuk</h2>
    <p class="text-muted text-center mb-4">Akses dashboard AgenPekerjaan Anda</p>

    @if ($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0 px-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label small mb-1 fw-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@domain.com" class="form-control" required autofocus>
        </div>

        <div class="mb-4">
            <label class="form-label small mb-1 fw-semibold">Password</label>
            <input type="password" name="password" placeholder="Password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100 py-2 rounded-pill fw-bold">Login</button>
    </form>

    <p class="mt-3 text-center mb-0 small">
        Belum memiliki akun perusahaan?
        <a href="{{ route('register') }}" class="fw-semibold">Daftar di sini</a>
    </p>
</div>
@endsection