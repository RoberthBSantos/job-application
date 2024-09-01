<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Job;

class HomeController extends Controller
{
    /**
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jobs = Job::latest()->take(5)->get(); // Pega as 5 vagas mais recentes
        return view('welcome', compact('jobs')); // Certifique-se de que o nome da view está correto
    }
}
