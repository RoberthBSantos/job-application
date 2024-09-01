<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidate::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $perPage = $request->get('per_page', 20);
        $candidates = $query->paginate($perPage);

        return response()->json($candidates, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $candidate = Candidate::create($validated);

        return response()->json([
            'message' => 'Candidato criado com sucesso!',
            'data' => $candidate
        ], 201);
    }

    public function apply(Request $request, $id)
    {
        $validated = $request->validate([
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:job_positions,id',
        ]);

        $candidate = Candidate::findOrFail($id);

        $candidate->jobs()->syncWithoutDetaching($validated['job_ids']);

        return response()->json([
            'message' => 'Candidato inscrito nas vagas selecionadas com sucesso!',
            'data' => $candidate
        ], 200);
    }

    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . $candidate->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $candidate->update($validated);

        return response()->json([
            'message' => 'Candidato atualizado com sucesso!',
            'data' => $candidate
        ], 200);
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return response()->json(['message' => 'Candidato excluído com sucesso!'], 200);
    }

    public function massDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:candidates,id'
        ]);

        Candidate::whereIn('id', $validated['ids'])->delete();

        return response()->json(['message' => 'Candidatos excluídos com sucesso!'], 200);
    }
}
