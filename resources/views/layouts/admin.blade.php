<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin') — Vitrine Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body x-data="{ open: false }" class="bg-gray-100 text-gray-800 min-h-screen flex">

    <!-- Mobile overlay -->
    <div x-show="open" x-transition.opacity x-cloak @click="open=false"
         class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>

    <!-- Sidebar -->
    <aside class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-gray-900 text-gray-100 flex flex-col
                  transform md:transform-none transition-transform duration-200"
           :class="{ '-translate-x-full md:translate-x-0': !open, 'translate-x-0': open }">

        <div class="px-5 py-4 border-b border-gray-700 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-white text-lg">Vitrine</a>
                <p class="text-xs text-gray-400 mt-0.5">Painel de Administração</p>
            </div>
            <button class="md:hidden w-8 h-8 flex items-center justify-center rounded hover:bg-gray-700"
                    @click="open=false">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-2 py-4 text-sm space-y-1">

            <p class="px-3 pt-2 pb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-500">Plataforma</p>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded hover:bg-gray-800 @yield('nav.admin.dashboard')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
                </svg>
                Visão Geral
            </a>

            <p class="px-3 pt-4 pb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-500">Gestão</p>
            <a href="{{ route('admin.entities.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded hover:bg-gray-800 @yield('nav.admin.entities')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Empresas / Lojas
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded hover:bg-gray-800 @yield('nav.admin.categories')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
                </svg>
                Categorias
            </a>
            <a href="{{ route('admin.delivery-partners.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded hover:bg-gray-800 @yield('nav.delivery')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Parceiros de Entrega
            </a>

            <p class="px-3 pt-4 pb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-500">Conta</p>
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-2.5 px-3 py-2 rounded hover:bg-gray-800 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Ver Plataforma
            </a>
        </nav>

        <div class="p-3 border-t border-gray-700 text-xs text-gray-500 space-y-2">
            <div class="text-gray-400">{{ auth()->user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-400 hover:text-red-300 hover:underline">Sair</button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-h-screen">
        <header class="bg-white border-b px-4 sm:px-6 py-3 flex items-center gap-4">
            <button class="md:hidden w-9 h-9 flex items-center justify-center rounded hover:bg-gray-100"
                    @click="open=true">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex-1 flex items-center justify-between">
                <h1 class="font-semibold text-lg">@yield('header', 'Admin')</h1>
                <span class="text-xs bg-gray-900 text-white px-2 py-1 rounded font-medium">Admin</span>
            </div>
        </header>

        <main class="flex-1 px-4 sm:px-6 py-6 space-y-6">
            @foreach(['success' => 'green', 'error' => 'red', 'warning' => 'yellow', 'info' => 'blue'] as $type => $color)
                @if(session($type))
                    <div class="rounded border border-{{ $color }}-300 bg-{{ $color }}-50 px-4 py-3 text-sm text-{{ $color }}-800">
                        {{ session($type) }}
                    </div>
                @endif
            @endforeach
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
