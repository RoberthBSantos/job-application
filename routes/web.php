<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\JobController;
use App\Http\Controllers\Web\CandidateController;

Route::get('/', [JobController::class, 'index'])->name('home');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
Route::delete('/jobs/mass-destroy', [JobController::class, 'massDestroy'])->name('jobs.massDestroy');

Route::delete('/candidates/mass-destroy', [CandidateController::class, 'massDestroy'])->name('candidates.massDestroy');
Route::get('/candidates/{id}/apply', [CandidateController::class, 'showApplyForm'])->name('candidates.showApplyForm');
Route::post('/candidates/{id}/apply', [CandidateController::class, 'apply'])->name('candidates.apply');
Route::resource('candidates', CandidateController::class);


