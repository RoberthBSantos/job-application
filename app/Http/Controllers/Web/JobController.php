<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $perPage = $request->get('per_page', 20);
        $jobs = $query->paginate($perPage);

        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:CLT,PJ,Freelancer',
            'paused' => 'boolean'
        ]);

        Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Vaga criada com sucesso!');
    }

    public function edit(Job $job)
    {
        logger()->info('Entrou no método edit');
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $request->merge(['paused' => $request->has('paused')]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:CLT,PJ,Freelancer',
            'paused' => 'nullable|boolean'
        ]);


        $job->update($validated);


        return redirect()->route('jobs.index')->with('success', 'Vaga atualizada com sucesso!');
    }


    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Vaga excluída com sucesso!');
    }

    public function massDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:jobs,id'
        ]);

        Job::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('jobs.index')->with('success', 'Vagas excluídas com sucesso!');
    }
}
