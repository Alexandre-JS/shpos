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

    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('preload')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen flex flex-col text-gray-800" style="background:#FFFFFF">

    {{-- ── Navbar principal (Compacta) ─────────────────────────────────────────── --}}
    <header x-data="{ open: false }" style="background:#FFFFFF" class="sticky top-0 z-50 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between gap-8">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="shrink-0 transition-opacity hover:opacity-90">
                <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }} — Vitrine Digital de Moçambique" class="h-14 w-auto">
            </a>

            {{-- Central Large Search --}}
            <div class="flex-1 hidden md:block max-w-2xl">
                <div class="relative group">
                    <x-search-bar live="true" />
                </div>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-4 text-sm font-semibold shrink-0">
                @auth
                <a href="{{ route('dashboard.index') }}" class="text-gray-600 hover:text-orange-600 transition-colors">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-gray-400 hover:text-red-500 transition-colors">Sair</button>
                </form>
                @else
                <a href="{{ route('login.show') }}" class="text-gray-600 hover:text-orange-500 transition-colors">Entrar</a>
                <a href="{{ route('register.show') }}"
                    class="px-5 py-2 rounded-xl text-sm font-bold border-2 border-orange-500 text-orange-600 hover:bg-orange-500 hover:text-white transition-all">
                    Criar Loja
                </a>
                @endauth

                {{-- Mobile Toggle --}}
                <button class="md:hidden p-2 text-gray-500" @click="open=!open">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Row 2: Categorias horizontal (Desktop) --}}
        <div class="hidden md:block border-t border-gray-100 bg-white" x-data="{ openAllCats: false }">
            <div class="max-w-7xl mx-auto px-4 relative">
                <nav class="flex items-center justify-between py-1.5">
                    <div class="flex items-center gap-1">
                        <a href="{{ route('products') }}"
                            class="px-4 py-2 text-[11px] font-bold text-orange-600 bg-orange-50 rounded-lg whitespace-nowrap transition-all tracking-wide">
                            Todos
                        </a>

                        @foreach($globalCategories->take(5) as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}"
                            class="px-4 py-2 text-[11px] font-bold text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg whitespace-nowrap transition-all tracking-wide">
                            {{ $cat->name }}
                        </a>
                        @endforeach

                        @if($globalCategories->count() > 5)
                        <button @click="openAllCats = !openAllCats"
                            class="px-4 py-2 text-[11px] font-bold text-orange-600 hover:bg-orange-600 hover:text-white rounded-lg whitespace-nowrap tracking-wide flex items-center gap-2 transition-all shadow-sm">
                            <span>Mais Categorias</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 transition-transform" :class="openAllCats ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        @endif
                    </div>
                </nav>

                {{-- Dropdown de Categorias Completo --}}
                <div x-show="openAllCats"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    @click.away="openAllCats = false"
                    class="absolute left-4 right-4 top-full bg-white border border-gray-100 shadow-2xl rounded-2xl z-50 p-6 grid grid-cols-4 gap-4 mt-1">
                    <div class="col-span-4 mb-2 pb-2 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-600">Todas as Categorias</h3>
                        <a href="{{ route('products') }}" class="text-[10px] font-bold text-gray-400 hover:text-orange-600 uppercase tracking-widest transition-colors">Ver Tudo →</a>
                    </div>
                    @foreach($globalCategories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="flex items-center gap-3 group">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-100 group-hover:bg-orange-500 transition-colors"></span>
                        <span class="text-sm text-gray-600 group-hover:text-orange-600 transition-colors font-medium">{{ $cat->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Mobile panel --}}
        <div x-show="open" x-cloak class="md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-3 space-y-3">
                <x-search-bar live="true" />

                {{-- Mobile Categories --}}
                <div class="py-2">
                    <p class="text-[10px] font-black uppercase text-gray-400 mb-2 px-2">Categorias</p>
                    <div class="grid grid-cols-2 gap-1">
                        <a href="{{ route('products') }}" class="text-orange-600 font-bold py-2 px-2 text-xs bg-orange-50 rounded-lg">Ver Tudo</a>
                        @foreach($globalCategories->take(5) as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="text-gray-600 py-2 px-2 text-xs hover:bg-orange-50 rounded-lg">{{ $cat->name }}</a>
                        @endforeach
                    </div>
                </div>

                <nav class="flex flex-col space-y-2 pb-2 border-t border-gray-50 pt-2">
                    <a href="{{ route('products') }}" class="text-gray-600 py-2">Todos os Produtos</a>
                    <a href="{{ route('entities.index') }}" class="text-gray-600 py-2">Lojas</a>
                    <a href="{{ route('login.show') }}" class="text-gray-600 py-2">Entrar</a>
                    <a href="{{ route('register.show') }}" class="text-orange-600 font-bold py-2">Criar Loja</a>
                </nav>
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

    <footer class="mt-16 border-t py-8 text-xs text-gray-400" style="background:#FFFFFF">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} Shops. Todos os direitos reservados.</p>
            <nav class="flex flex-wrap gap-x-5 gap-y-1 justify-center">
                <a href="{{ route('about') }}" class="hover:text-orange-600 transition-colors">Sobre</a>
                <a href="{{ route('delivery-partners') }}" class="hover:text-orange-600 transition-colors">Parceiros de Entrega</a>
                <a href="{{ route('contact') }}" class="hover:text-orange-600 transition-colors">Contacto</a>
                <a href="{{ route('terms') }}" class="hover:text-orange-600 transition-colors">Termos de Uso</a>
                <a href="{{ route('privacy') }}" class="hover:text-orange-600 transition-colors">Privacidade</a>
                <a href="mailto:suporte@shops.co.mz" class="hover:text-orange-600 transition-colors">suporte@shops.co.mz</a>
            </nav>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>