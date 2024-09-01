@extends('layout.app')

@section('title', 'Inscrever Candidato em Vagas')

@section('content')
<h1>Inscrever {{ $candidate->name }} em Vagas</h1>

<form method="GET" action="{{ route('candidates.apply', $candidate->id) }}" class="mb-3">
    <label for="job_name">Filtrar por nome da vaga:</label>
    <input type="text" name="job_name" id="job_name" value="{{ request('job_name') }}" placeholder="Nome da vaga">
    
    <label for="job_type">Filtrar por tipo de vaga:</label>
    <select name="job_type" id="job_type">
        <option value="">Todos os tipos</option>
        <option value="CLT" {{ request('job_type') == 'CLT' ? 'selected' : '' }}>CLT</option>
        <option value="PJ" {{ request('job_type') == 'PJ' ? 'selected' : '' }}>PJ</option>
        <option value="Freelancer" {{ request('job_type') == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
    </select>

    <button type="submit" class="btn btn-info">Filtrar</button>
</form>

<form action="{{ route('candidates.apply', $candidate->id) }}" method="POST">
    @csrf

    <label for="job_ids">Escolha as vagas:</label>
    <div>
        @foreach($jobs as $job)
            <div>
                <input type="checkbox" name="job_ids[]" value="{{ $job->id }}" id="job_{{ $job->id }}">
                <label for="job_{{ $job->id }}">{{ $job->title }} - {{ ucfirst($job->type) }}</label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Inscrever</button>
    <a href="{{ route('candidates.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
