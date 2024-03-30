<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\KolController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\ProjectTaskViewController;
use App\Http\Controllers\ProjectTaskApplicationController;


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

Route::get('/project/task/new', [ProjectTaskController::class, 'task_new']);
Route::post('/project/task/new', [ProjectTaskController::class, 'task_new']);

Route::get('/project/task/list', [ProjectTaskController::class, 'task_list']);
Route::post('/project/task/list', [ProjectTaskController::class, 'task_list']);

Route::get('/project/task/detail', [ProjectTaskController::class, 'task_detail']);
Route::post('/project/task/detail', [ProjectTaskController::class, 'task_detail']);

Route::get('/project/task/view', [ProjectTaskViewController::class, 'task_view']);
Route::post('/project/task/view', [ProjectTaskViewController::class, 'task_view']);

Route::get('/project/task/application', [ProjectTaskApplicationController::class, 'task_application']);
Route::post('/project/task/application', [ProjectTaskApplicationController::class, 'task_application']);

Route::get('/project/task/application/detail', [ProjectTaskApplicationController::class, 'task_application_detail']);
Route::post('/project/task/application/detail', [ProjectTaskApplicationController::class, 'task_application_detail']);

Route::get('/project/task/application/cancel', [ProjectTaskApplicationController::class, 'task_application_cancel']);
Route::post('/project/task/application/cancel', [ProjectTaskApplicationController::class, 'task_application_cancel']);


Route::get('/kol/new', [KolController::class, 'kol_new']);
Route::post('/kol/new', [KolController::class, 'kol_new']);

Route::get('/kol/list', [KolController::class, 'kol_list']);
Route::post('/kol/list', [KolController::class, 'kol_list']);




