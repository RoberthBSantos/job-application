<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
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
        <section>
            <h1>Bem-vindo à Página Inicial!</h1>
            <p>Explore nossas vagas e encontre a oportunidade perfeita para você!</p>
        </section>

        <section>
            <h2>Últimas Vagas</h2>
            @foreach($jobs as $job)
                <div>
                    <h3>{{ $job->title }}</h3>
                    <p>Tipo: {{ $job->type }}</p>
                    <p><a href="{{ route('jobs.show', $job->id) }}">Ver detalhes</a></p>
                </div>
            @endforeach
        </section>
    </main>
    
    <footer>
        <p>&copy; {{ date('Y') }} Sua Empresa. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
