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
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\FileController;


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

Route::middleware('log.request.response')->group(function () {

});


Route::get('/test', [TestController::class, 'index']);

Route::get('/verification/code', [VerificationController::class, 'code']);
Route::post('/verification/code', [VerificationController::class, 'code']);

Route::get('/project/index', [ProjectController::class, 'project_index']);
Route::post('/project/index', [ProjectController::class, 'project_index']);

Route::get('/project/new', [ProjectController::class, 'project_new']);
Route::post('/project/new', [ProjectController::class, 'project_new']);

Route::get('/project/list', [ProjectController::class, 'project_list']);
Route::post('/project/list', [ProjectController::class, 'project_list']);

Route::get('/project/setting', [ProjectController::class, 'project_setting']);
Route::post('/project/setting', [ProjectController::class, 'project_setting']);

Route::get('/project/detail', [ProjectController::class, 'project_detail']);
Route::post('/project/detail', [ProjectController::class, 'project_detail']);

Route::get('/project/login', [ProjectController::class, 'login']);
Route::post('/project/login', [ProjectController::class, 'login']);

Route::get('/project/task/new', [ProjectTaskController::class, 'task_new']);
Route::post('/project/task/new', [ProjectTaskController::class, 'task_new']);

Route::get('/project/task/list', [ProjectTaskController::class, 'task_list']);
Route::post('/project/task/list', [ProjectTaskController::class, 'task_list']);

Route::get('/task/all', [ProjectTaskController::class, 'task_all']);
Route::post('/task/all', [ProjectTaskController::class, 'task_all']);

Route::get('/project/task/detail', [ProjectTaskController::class, 'task_detail']);
Route::post('/project/task/detail', [ProjectTaskController::class, 'task_detail']);

Route::get('/project/task/view', [ProjectTaskViewController::class, 'task_view']);
Route::post('/project/task/view', [ProjectTaskViewController::class, 'task_view']);

Route::get('/project/task/application/new', [ProjectTaskApplicationController::class, 'task_application_new']);
Route::post('/project/task/application/new', [ProjectTaskApplicationController::class, 'task_application_new']);

Route::get('/project/task/application/detail', [ProjectTaskApplicationController::class, 'task_application_detail']);
Route::post('/project/task/application/detail', [ProjectTaskApplicationController::class, 'task_application_detail']);

Route::get('/project/task/application/cancel', [ProjectTaskApplicationController::class, 'task_application_cancel']);
Route::post('/project/task/application/cancel', [ProjectTaskApplicationController::class, 'task_application_cancel']);

Route::get('/project/task/application/edit', [ProjectTaskApplicationController::class, 'task_application_edit']);
Route::post('/project/task/application/edit', [ProjectTaskApplicationController::class, 'task_application_edit']);

Route::get('/project/task/application/review', [ProjectTaskApplicationController::class, 'task_application_review']);
Route::post('/project/task/application/review', [ProjectTaskApplicationController::class, 'task_application_review']);

Route::get('/project/task/application/upload', [ProjectTaskApplicationController::class, 'task_application_upload']);
Route::post('/project/task/application/upload', [ProjectTaskApplicationController::class, 'task_application_upload']);

Route::get('/project/task/application/finish', [ProjectTaskApplicationController::class, 'task_application_finish']);
Route::post('/project/task/application/finish', [ProjectTaskApplicationController::class, 'task_application_finish']);

Route::get('/kol/new', [KolController::class, 'kol_new']);
Route::post('/kol/new', [KolController::class, 'kol_new']);

Route::get('/kol/detail', [KolController::class, 'kol_detail']);
Route::post('/kol/detail', [KolController::class, 'kol_detail']);

Route::get('/kol/login', [KolController::class, 'login']);
Route::post('/kol/login', [KolController::class, 'login']);

Route::get('/kol/list', [KolController::class, 'kol_list']);
Route::post('/kol/list', [KolController::class, 'kol_list']);

Route::get('/kol/task/list', [KolController::class, 'kol_task_list']);
Route::post('/kol/task/list', [KolController::class, 'kol_task_list']);

Route::get('/config/list', [ConfigController::class, 'list']);
Route::post('/config/list', [ConfigController::class, 'list']);

Route::post('/file/upload', [FileController::class, 'upload']);

Route::get('/file/download/{file_name}', [FileController::class, 'download']);


