<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\KolController;
use App\Http\Controllers\ProjectTaskController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', [TestController::class, 'index']);

Route::get('/verification/code', [VerificationController::class, 'code']);
Route::post('/verification/code', [VerificationController::class, 'code']);

Route::get('/project/new', [ProjectController::class, 'project_new']);
Route::post('/project/new', [ProjectController::class, 'project_new']);

Route::get('/project/find_kol/list', [ProjectController::class, 'find_kol']);
Route::post('/project/find_kol/list', [ProjectController::class, 'find_kol']);


Route::get('/kol/new', [KolController::class, 'kol_new']);
Route::post('/kol/new', [KolController::class, 'kol_new']);

Route::get('/project/task/new', [ProjectTaskController::class, 'project_task_new']);
Route::post('/project/task/new', [ProjectTaskController::class, 'project_task_new']);





