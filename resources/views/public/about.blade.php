@extends('layouts.public')

@section('title', 'Tentang Kami')

@section('content')
    <!-- HEADER -->
    <div style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); color: white; padding: 60px 0; margin-bottom: 40px;">
        <div class="container">
            <h1 class="fw-bold mb-3">Tentang AgenPekerjaan</h1>
            <p class="mb-0">Menghubungkan talenta terbaik dengan peluang karir yang sempurna</p>
        </div>
    </div>

    <div class="container mb-5">
        <!-- ABOUT CONTENT -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Siapa Kami?</h2>
                <p class="text-muted mb-3">
                    AgenPekerjaan adalah platform penempatan kerja terpadu yang dirancang khusus untuk mempertemukan 
                    talenta terbaik dengan perusahaan-perusahaan terkemuka di Indonesia.
                </p>
                <p class="text-muted mb-3">
                    Kami percaya bahwa setiap individu berhak mendapatkan pekerjaan yang sesuai dengan skill, nilai, 
                    dan aspirasi mereka. Sebaliknya, setiap perusahaan berhak menemukan talenta terbaik untuk 
                    mendorong pertumbuhan bisnis mereka.
                </p>
                <p class="text-muted">
                    Dengan teknologi terkini dan tim yang berdedikasi, kami membangun ekosistem kerja yang efisien, 
                    transparan, dan menguntungkan bagi semua pihak.
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <div style="font-size: 120px;">
                    🚀
                </div>
            </div>
        </div>

        <!-- MISSION & VISION -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <div class="card p-5 h-100" style="border-left: 4px solid #3B82F6;">
                    <h4 class="fw-bold mb-3 text-primary">🎯 Misi Kami</h4>
                    <p class="text-muted mb-0">
                        Menyediakan platform penempatan kerja yang inovatif, aman, dan mudah digunakan untuk 
                        menghubungkan pekerja Indonesia dengan peluang karir terbaik di seluruh negeri.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card p-5 h-100" style="border-left: 4px solid #10b981;">
                    <h4 class="fw-bold mb-3" style="color: #10b981;">🌟 Visi Kami</h4>
                    <p class="text-muted mb-0">
                        Menjadi platform penempatan kerja terdepan di Asia Tenggara yang diberdayakan oleh teknologi 
                        dan dipercaya oleh jutaan pencari kerja serta ribuan perusahaan.
                    </p>
                </div>
            </div>
        </div>

        <!-- VALUES -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-4 text-center">Nilai-Nilai Kami</h2>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card text-center p-4 h-100">
                    <div style="font-size: 3rem; margin-bottom: 15px;">✨</div>
                    <h5 class="fw-bold mb-2">Integritas</h5>
                    <p class="text-muted small">Kami beroperasi dengan transparansi penuh dan integritas tinggi dalam setiap aspek bisnis.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card text-center p-4 h-100">
                    <div style="font-size: 3rem; margin-bottom: 15px;">🤝</div>
                    <h5 class="fw-bold mb-2">Kolaborasi</h5>
                    <p class="text-muted small">Kami membangun kemitraan yang kuat dengan pengguna dan perusahaan kami.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card text-center p-4 h-100">
                    <div style="font-size: 3rem; margin-bottom: 15px;">💡</div>
                    <h5 class="fw-bold mb-2">Inovasi</h5>
                    <p class="text-muted small">Kami terus berinovasi untuk memberikan solusi terbaik dan tercanggih.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card text-center p-4 h-100">
                    <div style="font-size: 3rem; margin-bottom: 15px;">🎯</div>
                    <h5 class="fw-bold mb-2">Keunggulan</h5>
                    <p class="text-muted small">Kami berkomitmen untuk memberikan layanan dan pengalaman terbaik.</p>
                </div>
            </div>
        </div>

        <!-- WHY CHOOSE US -->
        <div class="bg-light p-5 rounded mb-5">
            <h2 class="fw-bold mb-4 text-center">Mengapa Memilih AgenPekerjaan?</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="d-flex gap-3">
                        <div style="font-size: 1.5rem; min-width: 40px;">✅</div>
                        <div>
                            <h5 class="fw-bold">Perusahaan Terverifikasi</h5>
                            <p class="text-muted">Semua perusahaan melalui proses verifikasi ketat untuk memastikan kualitas lowongan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex gap-3">
                        <div style="font-size: 1.5rem; min-width: 40px;">📱</div>
                        <div>
                            <h5 class="fw-bold">Platform Mobile Friendly</h5>
                            <p class="text-muted">Akses platform dari mana saja, kapan saja, melalui desktop atau mobile.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex gap-3">
                        <div style="font-size: 1.5rem; min-width: 40px;">🔒</div>
                        <div>
                            <h5 class="fw-bold">Keamanan Data</h5>
                            <p class="text-muted">Data pribadi Anda dilindungi dengan enkripsi tingkat enterprise.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex gap-3">
                        <div style="font-size: 1.5rem; min-width: 40px;">⚡</div>
                        <div>
                            <h5 class="fw-bold">Proses Cepat</h5>
                            <p class="text-muted">Dari pendaftaran hingga wawancara, semua proses dirancang untuk efisiensi maksimal.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex gap-3">
                        <div style="font-size: 1.5rem; min-width: 40px;">👥</div>
                        <div>
                            <h5 class="fw-bold">Tim Support 24/7</h5>
                            <p class="text-muted">Tim dukungan pelanggan kami siap membantu Anda kapan pun Anda membutuhkannya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex gap-3">
                        <div style="font-size: 1.5rem; min-width: 40px;">📊</div>
                        <div>
                            <h5 class="fw-bold">Analytics & Insights</h5>
                            <p class="text-muted">Dashboard yang komprehensif untuk melacak status lamaran dan pengembangan karir.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTACT -->
        <div class="row">
            <div class="col-12">
                <h2 class="fw-bold mb-4 text-center">Hubungi Kami</h2>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <h5 style="font-size: 2rem; margin-bottom: 10px;">📧</h5>
                    <h6 class="fw-bold mb-2">Email</h6>
                    <p class="text-muted mb-0">info@agenpekerjaan.com</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <h5 style="font-size: 2rem; margin-bottom: 10px;">📱</h5>
                    <h6 class="fw-bold mb-2">Telepon</h6>
                    <p class="text-muted mb-0">+62 8xx xxxx xxxx</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <h5 style="font-size: 2rem; margin-bottom: 10px;">📍</h5>
                    <h6 class="fw-bold mb-2">Alamat</h6>
                    <p class="text-muted mb-0">Jakarta, Indonesia</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="alert alert-light border mt-5 p-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #f0f4ff 100%);">
            <div class="text-center">
                <h4 class="fw-bold mb-3">Siap Bergabung dengan AgenPekerjaan?</h4>
                <p class="text-muted mb-4">Daftar sekarang dan mulai cari lowongan kerja impian Anda atau posting lowongan untuk menemukan talenta terbaik.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    Daftar Sekarang →
                </a>
            </div>
        </div>
    </div>
@endsection
