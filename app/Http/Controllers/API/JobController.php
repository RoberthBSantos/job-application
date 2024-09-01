<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
    
        return response()->json($jobs, 200);
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:CLT,PJ,Freelancer',
            'paused' => 'boolean'
        ]);

        $job = Job::create($validated);

        return response()->json([
            'message' => 'Vaga criada com sucesso!',
            'data' => $job
        ], 201);
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

        return response()->json([
            'message' => 'Vaga atualizada com sucesso!',
            'data' => $job
        ], 200);
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return response()->json(['message' => 'Vaga excluída com sucesso!'], 200);
    }

    public function massDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array', 
            'ids.*' => 'exists:jobs,id' 
        ]);

        Job::whereIn('id', $validated['ids'])->delete();

        return response()->json(['message' => 'Vagas excluídas com sucesso!'], 200);
    }
}
