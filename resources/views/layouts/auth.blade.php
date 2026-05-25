<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', config('app.name', 'M\'Shop')) - Autenticação</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body
    style="background: linear-gradient(135deg, var(--navy-blue) 0%, var(--navy-dark) 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">
    <div style="width: 100%; max-width: 400px;">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
