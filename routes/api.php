<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'prefix'     => 'v1',
    'as'         => 'tasks.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('index');
    Route::post('tasks', [TaskController::class, 'store'])->name('store');
    Route::patch('tasks/{task}', [TaskController::class, 'update'])->name('update');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('destroy');
});
