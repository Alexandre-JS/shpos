<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard') - Vitrine</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('head')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="text-body min-vh-100 d-flex" style="background:#F8F9FF">

    <aside class="offcanvas-md offcanvas-start app-sidebar d-flex flex-column" tabindex="-1" id="dashSidebar">

        @php $dashEntity = auth()->user()?->entity; @endphp
        <div class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between gap-2">
            <div class="min-w-0">
                <a href="{{ route('dashboard.index') }}" class="fw-bold fs-6 text-body text-decoration-none d-block text-truncate" title="{{ $dashEntity?->name }}">
                    {{ $dashEntity?->name ?? config('app.name', 'Vitrine') }}
                </a>
                <p class="mb-0 small text-muted">Painel da Loja</p>
            </div>
            <button class="btn-close d-md-none flex-shrink-0" type="button" data-bs-dismiss="offcanvas" data-bs-target="#dashSidebar" aria-label="Fechar"></button>
        </div>

        <nav class="flex-grow-1 overflow-auto thin-scrollbar px-2 py-3 small vstack gap-1">
            <a href="{{ route('dashboard.index') }}" class="dash-link @yield('nav.dashboard')">
                <i class="bi bi-grid-1x2"></i><span>Visão Geral</span>
            </a>
            <a href="{{ route('dashboard.products.index') }}" class="dash-link @yield('nav.products')">
                <i class="bi bi-box-seam"></i><span>Produtos / Serviços</span>
            </a>
            <a href="{{ route('dashboard.entity.settings.edit') }}" class="dash-link @yield('nav.entity')">
                <i class="bi bi-shop"></i><span>Minha Loja</span>
            </a>
            <a href="{{ route('dashboard.stats') }}" class="dash-link @yield('nav.stats')">
                <i class="bi bi-bar-chart"></i><span>Estatísticas</span>
            </a>
        </nav>

        <div class="p-3 border-top vstack gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-secondary flex-shrink-0" style="width:2rem;height:2rem;"><i class="bi bi-person"></i></span>
                <div class="min-w-0">
                    <p class="small fw-medium text-truncate mb-0">{{ auth()->user()->name ?? '' }}</p>
                    <p class="text-muted text-truncate mb-0" style="font-size:.7rem;">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                @if ($dashEntity)
                    <a href="{{ route('entity.show', $dashEntity->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm flex-fill"><i class="bi bi-shop me-1"></i>Ver loja</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" title="Terminar sessão"><i class="bi bi-box-arrow-right me-1"></i>Sair</button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-grow-1 d-flex flex-column min-vh-100">
        <header class="bg-white border-bottom px-3 px-sm-4 py-3 d-flex align-items-center gap-3 shadow-sm">
            <button class="btn btn-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#dashSidebar" aria-controls="dashSidebar">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                <h1 class="fw-semibold fs-5 mb-0">@yield('header', 'Dashboard')</h1>
                <a href="{{ route('dashboard.products.create') }}" class="btn btn-secondary btn-sm d-none d-sm-inline-flex">
                    + Novo produto
                </a>
            </div>
        </header>

        <main class="flex-grow-1 px-3 px-sm-4 py-4 vstack gap-4">
            @foreach(['success' => 'alert-success', 'error' => 'alert-danger', 'info' => 'alert-info', 'warning' => 'alert-warning'] as $type => $cls)
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
