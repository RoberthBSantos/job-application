@extends('layout.app')

@section('title', 'Editar Vaga')

@section('content')
<h1>Editar Vaga</h1>

<form action="{{ route('jobs.update', $job->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $job->title }}" required>
    </div>
    <div class="form-group">
        <label for="type">Tipo</label>
        <select name="type" id="type" class="form-control" required>
            <option value="CLT" {{ $job->type == 'CLT' ? 'selected' : '' }}>CLT</option>
            <option value="PJ" {{ $job->type == 'PJ' ? 'selected' : '' }}>Pessoa Jurídica</option>
            <option value="Freelancer" {{ $job->type == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
        </select>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" name="paused" id="paused" class="form-check-input" {{ $job->paused ? 'checked' : '' }}>
        <label class="form-check-label" for="paused">Pausar Vaga</label>
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
