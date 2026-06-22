<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @php
    $seoTitle = trim(strip_tags($__env->yieldContent('title', '')));
    $appName = config('app.name', 'Vitrine');
    $fullTitle = $seoTitle ? "{$seoTitle} — {$appName}" : $appName;
    $metaDesc = trim(strip_tags($__env->yieldContent('meta_description', "Descubra produtos e serviços de empresas moçambicanas em {$appName}.")));
    $ogImage = trim($__env->yieldContent('og_image', asset('images/og-default.png')));
    $ogType = trim($__env->yieldContent('og_type', 'website'));
    @endphp

    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}" />

    <meta property="og:title" content="{{ $fullTitle }}" />
    <meta property="og:description" content="{{ $metaDesc }}" />
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="{{ $ogType }}" />
    <meta property="og:site_name" content="{{ $appName }}" />
    <meta property="og:locale" content="pt_MZ" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $fullTitle }}" />
    <meta name="twitter:description" content="{{ $metaDesc }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @stack('meta')
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('preload')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="d-flex min-vh-100 flex-column">

    <header class="site-header shadow-sm">
        <div class="app-container d-flex align-items-center justify-content-between gap-4 py-2">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex-shrink-0" aria-label="Página inicial">
                <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" style="height:3rem;width:auto;">
            </a>

            {{-- Pesquisa central --}}
            <div class="flex-grow-1 d-none d-md-block" style="max-width:42rem;">
                <x-search-bar live="true" />
            </div>

            {{-- Ações de conta (desktop) --}}
            <div class="d-none d-md-flex align-items-center gap-3 flex-shrink-0 fw-semibold small">
                @auth
                <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard.index') }}" class="text-secondary-emphasis text-decoration-none">Painel</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 text-muted text-decoration-none">Sair</button>
                </form>
                @else
                <a href="{{ route('login.show') }}" class="text-secondary-emphasis text-decoration-none">Entrar</a>
                <a href="{{ route('register.show') }}" class="btn btn-primary fw-bold rounded-3 px-3">Criar Loja</a>
                @endauth
            </div>

            {{-- Toggler mobile --}}
            <button class="btn btn-light d-md-none rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavigation" aria-controls="mobileNavigation" aria-expanded="false" aria-label="Abrir menu">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>

        {{-- Navegação desktop --}}
        <div class="d-none d-md-block border-top bg-white">
            <div class="app-container">
                <nav class="navbar navbar-expand p-0" aria-label="Navegação principal">
                    <ul class="navbar-nav align-items-center gap-1 py-1">
                        <li class="nav-item"><a href="{{ route('products') }}" class="nav-link nav-link-soft px-3 py-2 small {{ request()->routeIs('products') ? 'active' : '' }}">Produtos</a></li>
                        <li class="nav-item"><a href="{{ route('services') }}" class="nav-link nav-link-soft px-3 py-2 small {{ request()->routeIs('services') ? 'active' : '' }}">Serviços</a></li>
                        <li class="nav-item"><a href="{{ route('entities.index') }}" class="nav-link nav-link-soft px-3 py-2 small {{ request()->routeIs('entities.*') ? 'active' : '' }}">Lojas</a></li>

                        @if($globalCategories->isNotEmpty())
                        <li class="vr mx-2 my-1"></li>
                        <li class="nav-item dropdown">
                            <button class="nav-link nav-link-soft px-3 py-2 small dropdown-toggle border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                Categorias
                            </button>
                            <div class="dropdown-menu p-3 shadow-lg border-0 rounded-4" style="width:min(40rem,calc(100vw - 2rem));">
                                <div class="row row-cols-2 row-cols-md-4 g-2">
                                    @foreach($globalCategories->take(8) as $cat)
                                    <div class="col">
                                        <a href="{{ route('category.show', $cat->slug) }}" class="dropdown-item rounded-3 py-2 text-truncate">{{ $cat->name }}</a>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('categories.index') }}" class="dropdown-item rounded-3 py-2 d-flex align-items-center justify-content-between fw-semibold text-primary">
                                    Ver todas as categorias <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>

        {{-- Navegação mobile --}}
        <div id="mobileNavigation" class="collapse d-md-none border-top bg-white">
            <div class="p-3 vstack gap-3">
                <x-search-bar live="true" />

                <nav class="row row-cols-3 g-2" aria-label="Navegação principal">
                    <div class="col"><a href="{{ route('products') }}" class="d-block text-center bg-light rounded-3 px-2 py-3 small fw-semibold text-body text-decoration-none">Produtos</a></div>
                    <div class="col"><a href="{{ route('services') }}" class="d-block text-center bg-light rounded-3 px-2 py-3 small fw-semibold text-body text-decoration-none">Serviços</a></div>
                    <div class="col"><a href="{{ route('entities.index') }}" class="d-block text-center bg-light rounded-3 px-2 py-3 small fw-semibold text-body text-decoration-none">Lojas</a></div>
                </nav>

                @if($globalCategories->isNotEmpty())
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <p class="mb-0 text-uppercase fw-bold text-muted" style="font-size:.625rem;letter-spacing:.16em;">Categorias</p>
                        <a href="{{ route('categories.index') }}" class="small fw-semibold link-primary text-decoration-none">Ver todas</a>
                    </div>
                    <div class="row row-cols-2 g-1">
                        @foreach($globalCategories->take(6) as $cat)
                        <div class="col"><a href="{{ route('category.show', $cat->slug) }}" class="d-block text-truncate rounded-2 px-3 py-2 small text-secondary-emphasis text-decoration-none">{{ $cat->name }}</a></div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="d-flex align-items-center gap-2 border-top pt-3">
                    @auth
                    <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard.index') }}" class="btn btn-primary fw-bold flex-fill rounded-3">Painel</a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted fw-semibold text-decoration-none">Sair</button>
                    </form>
                    @else
                    <a href="{{ route('login.show') }}" class="btn btn-outline-secondary flex-fill rounded-3">Entrar</a>
                    <a href="{{ route('register.show') }}" class="btn btn-primary fw-bold flex-fill rounded-3">Criar Loja</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    @if (session('success') || session('info') || session('warning') || session('error'))
    <div class="app-container mt-4 vstack gap-2">
        @if (session('success'))
        <div class="alert alert-success small mb-0">{{ session('success') }}</div>
        @endif
        @if (session('info'))
        <div class="alert alert-info small mb-0">{{ session('info') }}</div>
        @endif
        @if (session('warning'))
        <div class="alert alert-warning small mb-0">{{ session('warning') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger small mb-0">{{ session('error') }}</div>
        @endif
    </div>
    @endif

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="mt-5 border-top bg-white">
        <div class="app-container py-4">
            <div class="d-flex flex-column flex-md-row gap-4 align-items-md-center justify-content-md-between">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" style="height:2.5rem;width:auto;">
                    <p class="d-none d-sm-block mb-0 text-muted small" style="max-width:20rem;">Produtos e lojas moçambicanas num só lugar.</p>
                </div>
                <nav class="d-flex flex-wrap column-gap-4 row-gap-2 small text-muted" aria-label="Informação institucional">
                    <a href="{{ route('about') }}" class="link-secondary text-decoration-none">Sobre</a>
                    <a href="{{ route('delivery-partners') }}" class="link-secondary text-decoration-none">Entregas</a>
                    <a href="{{ route('contact') }}" class="link-secondary text-decoration-none">Contacto</a>
                    <a href="{{ route('terms') }}" class="link-secondary text-decoration-none">Termos</a>
                    <a href="{{ route('privacy') }}" class="link-secondary text-decoration-none">Privacidade</a>
                </nav>
            </div>
            <div class="mt-4 border-top pt-3">
                <p class="mb-0 text-muted" style="font-size:.6875rem;">&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
