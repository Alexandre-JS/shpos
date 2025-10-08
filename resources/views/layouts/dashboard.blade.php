<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard') - Vitrine</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

</head>

<body x-data="{ open: false }" class="bg-gray-100 text-gray-800 min-h-screen flex">
    <!-- Mobile overlay -->
    <div x-show="open" x-transition.opacity x-cloak @click="open=false" class="fixed inset-0 bg-black/40 z-30 md:hidden">
    </div>
    <aside
        class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-white border-r flex flex-col transform md:transform-none transition-transform duration-200"
        :class="{ '-translate-x-full md:translate-x-0': !open, 'translate-x-0': open }">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <div>
                <a href="/" class="font-bold text-lg">Vitrine</a>
                <p class="text-xs text-gray-500 mt-1">Painel da Entidade</p>
            </div>
            <button class="md:hidden w-8 h-8 flex items-center justify-center rounded hover:bg-gray-100"
                @click="open=false" aria-label="Fechar">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto thin-scrollbar px-2 py-4 text-sm space-y-1">
            <a href="{{ route('dashboard.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-100 @yield('nav.dashboard')">Visão Geral</a>
            <a href="{{ route('dashboard.products.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-100 @yield('nav.products')">Produtos / Serviços</a>
            <a href="{{ route('dashboard.entity.settings.edit') }}"
                class="block px-3 py-2 rounded hover:bg-gray-100 @yield('nav.entity')">Minha Entidade</a>
            <a href="{{ route('dashboard.stats') }}"
                class="block px-3 py-2 rounded hover:bg-gray-100 @yield('nav.stats')">Estatísticas</a>
        </nav>
        <div class="p-3 border-t text-xs text-gray-500 space-y-2">
            <div>© {{ date('Y') }} Vitrine</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-600 hover:underline">Sair</button>
            </form>
        </div>
    </aside>
    <div class="flex-1 flex flex-col min-h-screen">
        <header class="bg-white border-b px-4 sm:px-6 py-3 flex items-center gap-4">
            <button class="md:hidden w-9 h-9 flex items-center justify-center rounded hover:bg-gray-100"
                @click="open=true" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="flex-1 flex items-center justify-between">
                <h1 class="font-semibold text-lg md:text-xl">@yield('header', 'Dashboard')</h1>
                <div class="text-xs text-gray-500 hidden sm:block">Olá, {{ auth()->user()->name ?? 'Utilizador' }}</div>
            </div>
        </header>
        <main class="flex-1 px-4 sm:px-6 py-6 space-y-8">@yield('content')</main>
    </div>
    @stack('scripts')
</body>

</html>
