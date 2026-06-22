<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin') — Vitrine Admin</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('head')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-light text-body min-vh-100 d-flex">

    <!-- Sidebar -->
    <aside class="offcanvas-md offcanvas-start app-sidebar d-flex flex-column" tabindex="-1" id="adminSidebar">

        <div class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="fw-bold text-body fs-5 text-decoration-none">Vitrine</a>
                <p class="mb-0 small text-muted">Painel de Administração</p>
            </div>
            <button class="btn-close d-md-none" type="button" data-bs-dismiss="offcanvas" data-bs-target="#adminSidebar" aria-label="Fechar"></button>
        </div>

        <nav class="flex-grow-1 overflow-auto px-2 py-3 small vstack gap-1">
            <p class="px-3 pt-2 pb-1 fw-semibold text-uppercase text-secondary" style="font-size:.625rem;letter-spacing:.1em;">Plataforma</p>
            <a href="{{ route('admin.dashboard') }}" class="dash-link @yield('nav.admin.dashboard')">
                <i class="bi bi-grid-1x2"></i>Visão Geral
            </a>

            <p class="px-3 pt-3 pb-1 fw-semibold text-uppercase text-secondary" style="font-size:.625rem;letter-spacing:.1em;">Gestão</p>
            <a href="{{ route('admin.entities.index') }}" class="dash-link @yield('nav.admin.entities')">
                <i class="bi bi-shop"></i>Empresas / Lojas
            </a>
            <a href="{{ route('admin.categories.index') }}" class="dash-link @yield('nav.admin.categories')">
                <i class="bi bi-tags"></i>Categorias
            </a>
            <a href="{{ route('admin.delivery-partners.index') }}" class="dash-link @yield('nav.delivery')">
                <i class="bi bi-truck"></i>Parceiros de Entrega
            </a>

            <p class="px-3 pt-3 pb-1 fw-semibold text-uppercase text-secondary" style="font-size:.625rem;letter-spacing:.1em;">Conta</p>
            <a href="{{ route('home') }}" target="_blank" class="dash-link">
                <i class="bi bi-box-arrow-up-right"></i>Ver Plataforma
            </a>
        </nav>

        <div class="p-3 border-top vstack gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-secondary flex-shrink-0" style="width:2rem;height:2rem;"><i class="bi bi-person"></i></span>
                <div class="min-w-0">
                    <p class="small fw-medium text-truncate mb-0">{{ auth()->user()->name }}</p>
                    <p class="text-muted text-truncate mb-0" style="font-size:.7rem;">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0 d-grid">
                @csrf
                <button class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Sair</button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-grow-1 d-flex flex-column min-vh-100">
        <header class="bg-white border-bottom px-3 px-sm-4 py-3 d-flex align-items-center gap-3">
            <button class="btn btn-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                <h1 class="fw-semibold fs-5 mb-0">@yield('header', 'Admin')</h1>
                <span class="badge text-bg-dark">Admin</span>
            </div>
        </header>

        <main class="flex-grow-1 px-3 px-sm-4 py-4 vstack gap-4">
            @foreach(['success' => 'alert-success', 'error' => 'alert-danger', 'warning' => 'alert-warning', 'info' => 'alert-info'] as $type => $cls)
                @if(session($type))
                    <div class="alert {{ $cls }} mb-0">{{ session($type) }}</div>
                @endif
            @endforeach
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
