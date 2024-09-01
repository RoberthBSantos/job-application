<form action="{{ route('jobs.update', $job->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title">Título</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $job->title) }}" required>
    </div>

    <div class="form-group">
        <label for="type">Tipo</label>
        <select class="form-control" id="type" name="type" required>
            <option value="CLT" {{ $job->type == 'CLT' ? 'selected' : '' }}>CLT</option>
            <option value="PJ" {{ $job->type == 'PJ' ? 'selected' : '' }}>PJ</option>
            <option value="Freelancer" {{ $job->type == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
        </select>
    </div>

    <div class="form-check">
        <!-- Campo hidden para garantir que o valor '0' seja enviado caso a checkbox não esteja marcada -->
        <input type="hidden" name="paused" value="0">
        <input type="checkbox" class="form-check-input" id="paused" name="paused" value="1" {{ old('paused', $job->paused) ? 'checked' : '' }}>
        <label class="form-check-label" for="paused">Pausar Vaga</label>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
