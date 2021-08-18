<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Protects routes
Route::middleware(['auth:sanctum'])->group(function(){
    //Route to fetch all lists of tasks
    Route::get('customers/tasks',[TaskController::class, 'index']);

    //Route to Insert tasks into the Database
    Route::post('customers/tasks', [TaskController::class, 'store']);

    //Route to update tasks
    Route::put('customers/tasks/{id}', [TaskController::class, 'update']);

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
