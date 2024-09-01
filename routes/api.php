<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CandidateController;
use App\Http\Controllers\API\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return response()->json(['message' => 'Test route working']);
});

Route::post('/tokens/create', [AuthController::class, 'createToken']); 

Route::middleware('auth:sanctum')->group(function () {
    Route::get('jobs', [JobController::class, 'index']);            
    Route::post('jobs', [JobController::class, 'store']);           
    Route::put('jobs/{job}', [JobController::class, 'update']);     
    Route::delete('jobs/{job}', [JobController::class, 'destroy']); 
    Route::delete('jobs/mass-destroy', [JobController::class, 'massDestroy']); 

     Route::get('candidates', [CandidateController::class, 'index']);                
     Route::post('candidates', [CandidateController::class, 'store']);               
     Route::get('candidates/{candidate}', [CandidateController::class, 'show']);      
     Route::put('candidates/{candidate}', [CandidateController::class, 'update']);    
     Route::delete('candidates/{candidate}', [CandidateController::class, 'destroy']); 
     Route::delete('candidates/mass-destroy', [CandidateController::class, 'massDestroy']);
     Route::post('candidates/{id}/apply', [CandidateController::class, 'apply']); 
});
