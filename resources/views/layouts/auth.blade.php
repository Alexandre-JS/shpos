<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', config('app.name', 'Shops')) — Autenticação</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center px-3 py-5" style="background: linear-gradient(135deg, #EA580C 0%, #F97316 60%, #FB923C 100%);">

    <div class="w-100 vstack gap-4" style="max-width:@yield('auth_width', '28rem');">
        {{-- Logo --}}
        <div class="text-center">
            <a href="{{ route('home') }}" class="d-inline-block">
                <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="mx-auto" style="height:4rem;width:auto;filter:drop-shadow(0 4px 6px rgba(0,0,0,.15));">
            </a>
        </div>

        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
