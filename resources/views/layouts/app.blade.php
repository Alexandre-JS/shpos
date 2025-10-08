<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Plataforma')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen flex flex-col bg-white text-gray-800">
    <nav x-data="{ open: false }" class="bg-white shadow mb-6 border-b">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded hover:bg-gray-100"
                    aria-label="Menu" @click="open=!open">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <a href="{{ route('home') }}" class="font-bold text-lg">Vitrine</a>
            </div>
            <div class="hidden md:flex items-center gap-4 text-sm font-medium">
                @auth
                    <a href="{{ route('dashboard.index') }}" class="hover:text-primary">Dashboard</a>
                    <a href="{{ route('dashboard.products.index') }}" class="hover:text-primary">Meus Produtos</a>
                    <a href="{{ route('dashboard.products.create') }}" class="hover:text-primary">Novo</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="text-red-600 hover:underline">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login.show') }}" class="hover:text-primary">Login</a>
                    <a href="{{ route('register.show') }}" class="hover:text-primary">Registrar</a>
                @endauth
            </div>
        </div>
        <!-- Mobile panel -->
        <div x-show="open" x-transition.origin.top.left x-cloak class="md:hidden border-t bg-white">
            <div class="px-4 py-4 space-y-4 text-sm">
                @auth
                    <div class="text-xs uppercase text-gray-400">Área</div>
                    <a href="{{ route('dashboard.index') }}" class="block py-1">Dashboard</a>
                    <a href="{{ route('dashboard.products.index') }}" class="block py-1">Meus Produtos</a>
                    <a href="{{ route('dashboard.products.create') }}" class="block py-1">Novo Produto</a>
                    <a href="{{ route('dashboard.entity.settings.edit') }}" class="block py-1">Minha Entidade</a>
                    <form action="{{ route('logout') }}" method="POST" class="pt-2">
                        @csrf
                        <button class="text-red-600">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login.show') }}" class="block py-1">Login</a>
                    <a href="{{ route('register.show') }}" class="block py-1">Registrar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="px-3 sm:px-4">
        @if (session('success'))
            <div class="max-w-3xl mx-auto mb-4 bg-green-100 text-green-700 p-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="mt-16 py-8 text-center text-xs text-gray-500">&copy; {{ date('Y') }} Vitrine Digital</footer>
    @stack('scripts')
</body>

</html>
