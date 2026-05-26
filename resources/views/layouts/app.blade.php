<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @php
        $seoTitle       = trim(strip_tags($__env->yieldContent('title', '')));
        $appName        = config('app.name', 'Vitrine');
        $fullTitle      = $seoTitle ? "{$seoTitle} — {$appName}" : $appName;
        $metaDesc       = trim(strip_tags($__env->yieldContent('meta_description', "Descubra produtos e serviços de empresas moçambicanas em {$appName}.")));
        $ogImage        = trim($__env->yieldContent('og_image', asset('images/og-default.png')));
        $ogType         = trim($__env->yieldContent('og_type', 'website'));
    @endphp

    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}" />

    <meta property="og:title"       content="{{ $fullTitle }}" />
    <meta property="og:description" content="{{ $metaDesc }}" />
    <meta property="og:image"       content="{{ $ogImage }}" />
    <meta property="og:url"         content="{{ url()->current() }}" />
    <meta property="og:type"        content="{{ $ogType }}" />
    <meta property="og:site_name"   content="{{ $appName }}" />
    <meta property="og:locale"      content="pt_MZ" />

    <meta name="twitter:card"        content="summary_large_image" />
    <meta name="twitter:title"       content="{{ $fullTitle }}" />
    <meta name="twitter:description" content="{{ $metaDesc }}" />
    <meta name="twitter:image"       content="{{ $ogImage }}" />

    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('preload')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen flex flex-col text-gray-800" style="background:#F8F9FF">

    {{-- ── Navbar principal ─────────────────────────────────────────── --}}
    <header x-data="{ open: false }" style="background:#1E1B4B" class="shadow-md">
        {{-- Linha 1: logo + search + auth --}}
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-4">

            {{-- Hamburger (mobile) --}}
            <button class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded hover:bg-white/10 text-white shrink-0"
                    aria-label="Menu" @click="open=!open">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="font-bold text-xl text-white tracking-tight shrink-0">
                {{ config('app.name', 'Vitrine') }}
            </a>

            {{-- Search bar (desktop) --}}
            <div class="flex-1 hidden md:block max-w-2xl mx-4">
                <x-search-bar live="true" />
            </div>

            {{-- Auth links --}}
            <div class="hidden md:flex items-center gap-3 text-sm font-medium shrink-0">
                @auth
                    <a href="{{ route('dashboard.index') }}" class="text-indigo-200 hover:text-white transition-colors">
                        <span class="hidden lg:inline">Dashboard</span>
                        <svg class="w-5 h-5 lg:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="text-indigo-300 hover:text-white text-sm transition-colors">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login.show') }}" class="text-indigo-200 hover:text-white transition-colors">Entrar</a>
                    <a href="{{ route('register.show') }}"
                       class="px-4 py-2 rounded text-sm font-semibold text-white transition-colors"
                       style="background:var(--color-accent)">Registar loja</a>
                @endauth
            </div>
        </div>

        {{-- Linha 2: secondary nav (desktop) --}}
        <div class="hidden md:block border-t border-indigo-800/60">
            <div class="max-w-7xl mx-auto px-4 flex items-center gap-1">
                <a href="{{ route('products') }}"
                   class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white transition-colors"
                   style="background:var(--color-accent)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    VER CATEGORIAS
                </a>
                <nav class="flex items-center overflow-x-auto">
                    <a href="{{ route('products') }}"            class="px-4 py-2.5 text-sm text-indigo-200 hover:text-white whitespace-nowrap transition-colors">Produtos</a>
                    <a href="{{ route('services') }}"            class="px-4 py-2.5 text-sm text-indigo-200 hover:text-white whitespace-nowrap transition-colors">Serviços</a>
                    <a href="{{ route('entities.index') }}"      class="px-4 py-2.5 text-sm text-indigo-200 hover:text-white whitespace-nowrap transition-colors">Lojas</a>
                    <a href="{{ route('products') }}?promo=1"    class="px-4 py-2.5 text-sm whitespace-nowrap transition-colors flex items-center gap-1" style="color:#FCD34D">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Promoções
                    </a>
                    <a href="{{ route('delivery-partners') }}"   class="px-4 py-2.5 text-sm text-indigo-200 hover:text-white whitespace-nowrap transition-colors">Entregas</a>
                </nav>
            </div>
        </div>

        {{-- Mobile panel --}}
        <div x-show="open" x-transition.origin.top.left x-cloak class="md:hidden border-t border-indigo-800" style="background:#1E1B4B">
            <div class="px-4 pt-3 pb-2">
                <x-search-bar live="true" />
            </div>
            <div class="px-4 pb-4 space-y-1 text-sm">
                <a href="{{ route('products') }}"         class="block py-2 text-indigo-200 hover:text-white">Produtos</a>
                <a href="{{ route('services') }}"         class="block py-2 text-indigo-200 hover:text-white">Serviços</a>
                <a href="{{ route('entities.index') }}"   class="block py-2 text-indigo-200 hover:text-white">Lojas</a>
                <a href="{{ route('products') }}?promo=1" class="block py-2 text-amber-300 hover:text-amber-100">⚡ Promoções</a>
                <a href="{{ route('delivery-partners') }}" class="block py-2 text-indigo-200 hover:text-white">Parceiros de Entrega</a>
                <hr class="border-indigo-800 my-2" />
                @auth
                    <a href="{{ route('dashboard.index') }}"        class="block py-2 text-indigo-200 hover:text-white">Dashboard</a>
                    <a href="{{ route('dashboard.products.index') }}" class="block py-2 text-indigo-200 hover:text-white">Meus Produtos</a>
                    <form action="{{ route('logout') }}" method="POST" class="pt-1">
                        @csrf
                        <button class="text-red-400 hover:text-red-300">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login.show') }}"   class="block py-2 text-indigo-200 hover:text-white">Entrar</a>
                    <a href="{{ route('register.show') }}" class="block py-2 text-white font-semibold">Registar loja</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    <div class="max-w-7xl mx-auto w-full px-4 mt-4">
        @if (session('success'))
            <div class="mb-3 bg-green-100 text-green-700 p-3 rounded text-sm">{{ session('success') }}</div>
        @endif
        @if (session('info'))
            <div class="mb-3 bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded text-sm">{{ session('info') }}</div>
        @endif
        @if (session('warning'))
            <div class="mb-3 bg-yellow-50 border border-yellow-200 text-yellow-800 p-3 rounded text-sm">{{ session('warning') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-3 bg-red-100 text-red-700 p-3 rounded text-sm">{{ session('error') }}</div>
        @endif
    </div>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-16 border-t py-8 text-xs text-gray-400" style="background:#F8F9FF">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
            <nav class="flex flex-wrap gap-x-5 gap-y-1 justify-center">
                <a href="{{ route('about') }}"            class="hover:text-gray-700 transition-colors">Sobre</a>
                <a href="{{ route('delivery-partners') }}" class="hover:text-gray-700 transition-colors">Parceiros de Entrega</a>
                <a href="{{ route('contact') }}"           class="hover:text-gray-700 transition-colors">Contacto</a>
                <a href="{{ route('terms') }}"             class="hover:text-gray-700 transition-colors">Termos de Uso</a>
                <a href="{{ route('privacy') }}"           class="hover:text-gray-700 transition-colors">Privacidade</a>
            </nav>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
