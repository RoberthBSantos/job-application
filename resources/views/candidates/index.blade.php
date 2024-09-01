@extends('layout.app')

@section('title', 'Listagem de Candidatos')

@section('content')
<h1>Listagem de Candidatos</h1>

<!-- Formulário de Pesquisa -->
<form action="{{ route('candidates.index') }}" method="GET" class="mb-4">
    <div class="form-row">
        <div class="col">
            <input type="text" name="name" class="form-control" placeholder="Nome do Candidato" value="{{ request('name') }}">
        </div>
        <div class="col">
            <input type="email" name="email" class="form-control" placeholder="Email do Candidato" value="{{ request('email') }}">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('candidates.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </div>
</form>

<!-- Formulário para selecionar o número de itens por página -->
<form action="{{ route('candidates.index') }}" method="GET" class="form-inline mb-3">
    <label for="per_page" class="mr-2">Itens por página:</label>
    <select name="per_page" id="per_page" class="form-control mr-2" onchange="this.form.submit()">
        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
    </select>
</form>

<form action="{{ route('candidates.massDestroy') }}" method="POST">
    @csrf
    @method('DELETE')

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th>
                <th>Nome</th>
                <th>Email</th>
                <th>Vagas Inscritas</th> <!-- Nova coluna para vagas -->
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($candidates as $candidate)
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{{ $candidate->id }}"></td>
                    <td>{{ $candidate->name }}</td>
                    <td>{{ $candidate->email }}</td>
                    <td>
                        @foreach ($candidate->jobs as $job)
                            <span class="badge badge-info">{{ $job->title }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('candidates.edit', $candidate->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                        <a href="{{ route('candidates.showApplyForm', $candidate->id) }}" class="btn btn-sm btn-success">Inscrever-se em Vagas</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-danger">Excluir Selecionados</button>
    <a href="{{ route('candidates.create') }}" class="btn btn-success">Criar Novo Candidato</a>
</form>

<!-- Exibir a paginação, mantendo os filtros na URL -->
<div class="pagination-container">
    {{ $candidates->appends(request()->except('page'))->links() }}
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
