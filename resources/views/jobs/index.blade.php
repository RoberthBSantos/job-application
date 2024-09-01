@extends('layout.app')

@section('title', 'Listagem de Vagas')

@section('content')
<h1>Listagem de Vagas</h1>

<!-- Formulário de Pesquisa -->
<form action="{{ route('jobs.index') }}" method="GET" class="mb-4">
    <div class="form-row">
        <div class="col">
            <input type="text" name="title" class="form-control" placeholder="Título da Vaga" value="{{ request('title') }}">
        </div>
        <div class="col">
            <select name="type" class="form-control">
                <option value="">Tipo</option>
                <option value="CLT" {{ request('type') == 'CLT' ? 'selected' : '' }}>CLT</option>
                <option value="PJ" {{ request('type') == 'PJ' ? 'selected' : '' }}>PJ</option>
                <option value="Freelancer" {{ request('type') == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
            </select>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </div>
</form>

<!-- Formulário para selecionar o número de itens por página -->
<form action="{{ route('jobs.index') }}" method="GET" class="form-inline mb-3">
    <label for="per_page" class="mr-2">Itens por página:</label>
    <select name="per_page" id="per_page" class="form-control mr-2" onchange="this.form.submit()">
        <option value="5" {{ request('per_page', 20) == 5 ? 'selected' : '' }}>5</option>
        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10</option>
        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
        <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50</option>
        <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100</option>
    </select>
</form>

<!-- Tabela de Vagas -->
<form action="{{ route('jobs.massDestroy') }}" method="POST">
    @csrf
    @method('DELETE')

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{{ $job->id }}"></td>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->type }}</td>
                    <td>
                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-danger">Excluir Selecionados</button>
    <a href="{{ route('jobs.create') }}" class="btn btn-success">Criar Nova Vaga</a>
</form>

<!-- Exibir a paginação, mantendo o parâmetro 'per_page' na URL -->
<div class="pagination-container">
    {{ $jobs->appends(request()->except('page'))->links() }}
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('select-all').addEventListener('click', function(event) {
        const checkboxes = document.querySelectorAll('input[name="ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
    });
</script>
@endsection
