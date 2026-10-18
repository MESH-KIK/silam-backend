<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILAM - Sistem Laundry Mandiri</title>

    <link rel="preconnect" href="https://api.fontshare.com" crossorigin>
    <link rel="stylesheet" href="https://api.fontshare.com/v2/css?f[]=general-sans@400,500,600,700&display=swap">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('bs/css/silam-layout.css') }}">
    @stack('styles')
</head>
<body>

    <header class="sticky-top px-3 pt-3">
        <nav class="navbar navbar-expand-lg navbar-silam bg-white bg-opacity-75 border rounded-5 shadow-sm mx-auto px-3 py-2"
             style="max-width: 1120px; backdrop-filter: blur(10px);">

            <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="/beranda">
                <img src="{{ asset('picture/silam_kecil.png') }}" alt="Logo SILAM" width="40" height="40">
                <span class="d-flex flex-column lh-1">
                    <span class="fw-bold fs-6 footer-navy">SILAM</span>
                    <small class="text-secondary" style="font-size: .6rem;">Sistem Laundry Mandiri</small>
                </span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto align-items-lg-center small">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('beranda*') ? 'active' : '' }}" href="/beranda">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tentang</a>
                        <ul class="dropdown-menu border-0 shadow rounded-4 p-2 mt-3">
                            <li><a class="dropdown-item rounded-3 small" href="/beranda#tentang">Tentang Kami</a></li>
                            <li><a class="dropdown-item rounded-3 small" href="/beranda#layanan">Layanan</a></li>
                            <li><a class="dropdown-item rounded-3 small" href="/beranda#keutamaan">Keutamaan</a></li>
                            <li><a class="dropdown-item rounded-3 small" href="/beranda#testimoni">Testimoni</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('outlet*') ? 'active' : '' }}" href="/outlet">Outlet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('status*') ? 'active' : '' }}" href="/status">Cek Status Cucianmu</a>
                    </li>
                </ul>

                <button type="button" class="btn btn-silam btn-sm rounded-pill px-4 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#loginModal">
                    Login
                </button>
            </div>
        </nav>
    </header>

    <main class="container-fluid px-4 pt-4">
        @yield('isikonten')
    </main>

    <footer class="site-footer mt-5 pt-5">
        <div class="container">
            <div class="row g-4 justify-content-between">

                <div class="col-lg-4 col-md-6">
                    <a class="d-flex align-items-center gap-2 text-decoration-none" href="/beranda">
                        <img src="{{ asset('picture/silam_kecil.png') }}" alt="Logo SILAM" width="40" height="40">
                        <span class="d-flex flex-column lh-1">
                            <span class="fw-bold footer-navy">SILAM</span>
                            <small class="text-secondary" style="font-size: .6rem;">Sistem Laundry Mandiri</small>
                        </span>
                    </a>
                    <p class="text-secondary small mt-3 mb-0" style="max-width: 300px;">
                        Platform sistem manajemen laundry modern yang dirancang untuk memberikan
                        kemudahan, kecepatan, penuh bagi pelanggan.
                    </p>
                </div>

                <div class="col-lg-3 col-6">
                    <h6 class="fw-bold footer-navy mb-3">Menu</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><a class="link-secondary link-underline-opacity-0" href="/beranda">Beranda</a></li>
                        <li class="mb-2"><a class="link-secondary link-underline-opacity-0" href="/beranda#tentang">Tentang</a></li>
                        <li class="mb-2"><a class="link-secondary link-underline-opacity-0" href="/beranda#layanan">Layanan</a></li>
                        <li class="mb-2"><a class="link-secondary link-underline-opacity-0" href="/beranda#keutamaan">Keutamaan</a></li>
                        <li class="mb-2"><a class="link-secondary link-underline-opacity-0" href="/beranda#testimoni">Testimoni</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-6">
                    <h6 class="fw-bold footer-navy mb-3">Kontak Kami</h6>
                    <ul class="list-unstyled small text-secondary mb-0">
                        <li class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone-fill footer-navy"></i><span>+62 8752 7272 272</span>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-whatsapp footer-navy"></i><span>+62 8211 9793 095</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-top text-center small py-3 mt-5">
                Copyright &copy; SILAM Laundry {{ date('Y') }} | Managed By: MESH Team
            </div>
        </div>
    </footer>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 680px;">
            <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden p-2" style="background-color: #ffffff;">
                <div class="modal-body p-0">
                    <div class="row g-0 align-items-stretch">

                        <!-- Sisi Kiri (Card Gradient Banner) - 50% -->
                        <div class="col-md-6 d-none d-md-flex flex-column justify-content-between p-4 rounded-4"
                             style="background: linear-gradient(135deg, #8eaee9 0%, #dbe4ff 50%, #e2f0a5 100%); min-height: 380px;">

                            <!-- Logo & Title -->
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('picture/silam_logo.png') }}" alt="Logo SILAM" class="bg-white rounded-1 p-1 shadow-sm" style="width: 40px; height: 40px; object-fit: contain;">
                                <div>
                                    <h6 class="fw-bold mb-0" style="color: #2c3a5e;">SILAM</h6>
                                    <small class="text-secondary" style="font-size: 0.68rem; opacity: 0.85;">Sistem Laundry Mandiri</small>
                                </div>
                            </div>

                            <!-- Tagline Quote -->
                            <div class="mt-auto pt-4">
                                <h5 class="fw-bold lh-sm mb-0" style="color: #2c3a5e; font-size: 1.05rem;">
                                    "Solusi Cuci Mandiri: Cepat, Rapi, dan Terpercaya."
                                </h5>
                            </div>
                        </div>

                        <!-- Sisi Kanan (Form Login) - 50% -->
                        <div class="col-md-6 p-4 d-flex flex-column justify-content-center">
                            <div class="mb-3">
                                <h3 class="fw-bold mb-1" style="color: #384e85;">Login</h3>
                                <p class="text-muted small mb-0" style="font-size: 0.78rem;">Aplikasi SILAM (Sistem Laundry Mandiri)</p>
                            </div>

                            <form action="{{ route('loginaksi') }}" method="POST">
                                @csrf

                                @if($errors->has('email') || $errors->has('password'))
                                    <div class="alert alert-danger py-2 small rounded-4">
                                        {{ $errors->first('email') ?: $errors->first('password') }}
                                    </div>
                                @endif

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label small fw-semibold text-secondary mb-1" style="font-size: 0.8rem;">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                           class="form-control rounded-pill border-secondary-subtle px-3 py-2"
                                           placeholder="Enter your email" style="font-size: 0.85rem;" required>
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="password" class="form-label small fw-semibold text-secondary mb-1" style="font-size: 0.8rem;">Password</label>
                                    <input type="password" name="password" id="password"
                                           class="form-control rounded-pill border-secondary-subtle px-3 py-2"
                                           placeholder="Enter your password" style="font-size: 0.85rem;" required>
                                </div>

                                <button type="submit" class="btn rounded-pill text-white w-100 fw-semibold py-2 shadow-sm" style="background-color: #384e85; font-size: 0.88rem;">
                                    Login
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
