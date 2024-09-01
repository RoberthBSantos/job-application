<?php

namespace App\Http\Controllers\Web;

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

        return view('candidates.index', compact('candidates'));
    }

    public function create()
    {
        return view('candidates.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Candidate::create($validated);

        return redirect()->route('candidates.index')->with('success', 'Candidato criado com sucesso!');
    }

    public function showApplyForm($id)
{
    $candidate = Candidate::findOrFail($id);

    $jobs = Job::query();

    if (request()->filled('job_name')) {
        $jobs->where('title', 'like', '%' . request('job_name') . '%');
    }

    if (request()->filled('job_type')) {
        $jobs->where('type', request('job_type'));
    }

    $jobs->where('paused', false);

    $jobs = $jobs->get();

    return view('candidates.apply', compact('candidate', 'jobs'));
}


    public function apply(Request $request, $id)
    {

        $validated = $request->validate([
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:job_positions,id',
        ]);

        $candidate = Candidate::findOrFail($id);

        $candidate->jobs()->syncWithoutDetaching($validated['job_ids']);

        return redirect()->route('candidates.index')->with('success', 'Candidato inscrito nas vagas selecionadas com sucesso!');
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

        return redirect()->route('candidates.index')->with('success', 'Candidato atualizado com sucesso!');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Candidato excluído com sucesso!');
    }

    public function massDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:candidates,id'
        ]);

        Candidate::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidatos excluídos com sucesso!');
    }
}
