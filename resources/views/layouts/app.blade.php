<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | SILAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 d-print-none">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}"><i class="bi bi-droplet-fill"></i> SILAM</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="menu">
            @php $role = auth()->user()->role; @endphp
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('pesanan.*') ? 'active' : '' }}" href="{{ route('pesanan.index') }}">Pesanan</a></li>
                @if(in_array($role, ['administrator','kasir']))
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                @endif
                @if($role === 'administrator')
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}" href="{{ route('layanan.index') }}">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">User</a></li>
                @endif
            </ul>
            <span class="navbar-text me-3">{{ auth()->user()->nama_user }} <span class="badge bg-light text-primary">{{ $role }}</span></span>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i> Keluar</button>
            </form>
        </div>
    </div>
</nav>

<main class="container pb-5">
    @if(session('success')) <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if(session('error'))   <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Modal tambah/ubah yang dipakai bersama oleh halaman Layanan, Pelanggan, dan User
const modal = document.getElementById('formModal');
if (modal) {
    const form = modal.querySelector('form');
    const method = form.querySelector('[name=_method]');
    const title = modal.querySelector('.modal-title');
    modal.addEventListener('show.bs.modal', e => {
        const b = e.relatedTarget;
        form.reset();
        if (b && b.dataset.item) {
            const item = JSON.parse(b.dataset.item);
            form.action = b.dataset.url; method.value = 'PUT'; title.textContent = 'Ubah Data';
            Object.entries(item).forEach(([k, v]) => {
                const el = form.elements[k];
                if (el && el.type !== 'password') el.value = v ?? '';
            });
        } else {
            form.action = form.dataset.storeUrl; method.value = 'POST'; title.textContent = 'Tambah Data';
        }
    });
}
document.querySelectorAll('form[data-confirm]').forEach(f =>
    f.addEventListener('submit', e => { if (!confirm(f.dataset.confirm)) e.preventDefault(); }));
</script>
@stack('scripts')
</body>
</html>
