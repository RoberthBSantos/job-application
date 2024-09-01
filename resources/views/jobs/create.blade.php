@extends('layout.app')

@section('title', 'Criar Nova Vaga')

@section('content')
<h1>Criar Nova Vaga</h1>

<form action="{{ route('jobs.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="type">Tipo</label>
        <select name="type" id="type" class="form-control" required>
            <option value="CLT">CLT</option>
            <option value="PJ">Pessoa Jurídica</option>
            <option value="Freelancer">Freelancer</option>
        </select>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" name="paused" id="paused" class="form-check-input">
        <label class="form-check-label" for="paused">Pausar Vaga</label>
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
