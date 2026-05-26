<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard') - Vitrine</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

</head>

<body x-data="{ open: false }" class="text-gray-800 min-h-screen flex" style="background:#F8F9FF">
    <div x-show="open" x-transition.opacity x-cloak @click="open=false" class="fixed inset-0 bg-black/40 z-30 md:hidden"></div>

    <aside class="fixed md:static inset-y-0 left-0 z-40 w-64 flex flex-col transform md:transform-none transition-transform duration-200 border-r"
           style="background:#1E1B4B"
           :class="{ '-translate-x-full md:translate-x-0': !open, 'translate-x-0': open }">

        <div class="px-5 py-4 border-b border-indigo-800 flex items-center justify-between">
            <div>
                <a href="{{ route('home') }}" class="font-bold text-lg text-white tracking-tight">
                    {{ config('app.name', 'Vitrine') }}
                </a>
                <p class="text-xs mt-0.5" style="color:#a5b4fc">Painel da Loja</p>
            </div>
            <button class="md:hidden w-8 h-8 flex items-center justify-center rounded text-indigo-300 hover:bg-indigo-800"
                    @click="open=false">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto thin-scrollbar px-2 py-4 text-sm space-y-0.5">
            @php
                $navItem = fn($route, $label, $icon, $yield) =>
                    '<a href="'.route($route).'" class="flex items-center gap-2.5 px-3 py-2 rounded transition-colors text-indigo-200 hover:bg-indigo-800 hover:text-white '.($__env->yieldContent($yield)).'">'
                    .$icon.'<span>'.$label.'</span></a>';
            @endphp

            <a href="{{ route('dashboard.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded transition-colors text-indigo-200 hover:bg-indigo-800 hover:text-white @yield('nav.dashboard')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/></svg>
                <span>Visão Geral</span>
            </a>
            <a href="{{ route('dashboard.products.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded transition-colors text-indigo-200 hover:bg-indigo-800 hover:text-white @yield('nav.products')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                <span>Produtos / Serviços</span>
            </a>
            <a href="{{ route('dashboard.entity.settings.edit') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded transition-colors text-indigo-200 hover:bg-indigo-800 hover:text-white @yield('nav.entity')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                <span>Minha Loja</span>
            </a>
            <a href="{{ route('dashboard.stats') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded transition-colors text-indigo-200 hover:bg-indigo-800 hover:text-white @yield('nav.stats')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Estatísticas</span>
            </a>
        </nav>

        <div class="p-3 border-t border-indigo-800 text-xs space-y-2">
            <div class="text-indigo-300 truncate">{{ auth()->user()->name ?? '' }}</div>
            <div class="flex gap-3">
                <a href="{{ route('home') }}" class="text-indigo-300 hover:text-white">Ver loja</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-red-400 hover:text-red-300">Sair</button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen">
        <header class="bg-white border-b px-4 sm:px-6 py-3 flex items-center gap-4 shadow-sm">
            <button class="md:hidden w-9 h-9 flex items-center justify-center rounded hover:bg-gray-100" @click="open=true">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex-1 flex items-center justify-between">
                <h1 class="font-semibold text-lg">@yield('header', 'Dashboard')</h1>
                <a href="{{ route('dashboard.products.create') }}" class="btn btn-accent btn-sm hidden sm:inline-flex">
                    + Novo produto
                </a>
            </div>
        </header>

        <main class="flex-1 px-4 sm:px-6 py-6 space-y-6">
            @foreach(['success' => 'alert-success', 'error' => 'alert-error', 'info' => 'alert-info', 'warning' => 'alert-warning'] as $type => $cls)
                @if(session($type))
                    <div class="alert {{ $cls }}">{{ session($type) }}</div>
                @endif
            @endforeach
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>

</html>
