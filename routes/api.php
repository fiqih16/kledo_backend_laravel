<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\Api\OvertimesController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::patch('settings', [SettingsController::class, 'update']);
Route::post('employee', [EmployeesController::class, 'create']);
Route::get('employee', [EmployeesController::class, 'show']);
Route::post('overtime', [OvertimesController::class, 'create']);
Route::get('overtime', [OvertimesController::class, 'show']);
Route::get('overtime-pays/calculate', [OvertimesController::class, 'calculate']);