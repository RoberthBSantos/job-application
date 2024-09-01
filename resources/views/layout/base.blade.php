<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Página Inicial')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('jobs.index') }}">Vagas</a></li>
                <li><a href="{{ route('candidates.index') }}">Candidatos</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Sua Empresa. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
