@extends('layout.app')

@section('title', 'Criar Novo Candidato')

@section('content')
<h1>Criar Novo Candidato</h1>

<form action="{{ route('candidates.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="phone">Telefone</label>
        <input type="text" name="phone" id="phone" class="form-control">
    </div>
    <div class="form-group">
        <label for="address">Endereço</label>
        <input type="text" name="address" id="address" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('candidates.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
