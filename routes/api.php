<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

Route::get('/lol/{name}', [TestController::class, 'testMethod']);
Route::get('/test/{name?}', [TestController::class, 'covidMethod']);
Route::get('/overkill', [TestController::class, 'overkillMethod']);
Route::post('/save-student', [TestController::class, 'saveStudent']);

Route::post('/company/create', [\App\Http\Controllers\Company\CreateController::class, 'method']);
Route::post('/company/get', [\App\Http\Controllers\Company\GetController::class, 'method']);
Route::post('/company/edit', [\App\Http\Controllers\Company\EditController::class, 'method']);
Route::post('/company/delete', [\App\Http\Controllers\Company\DeleteController::class, 'method']);

Route::post('/practice-offer/create', [\App\Http\Controllers\PracticeOffer\CreateController::class, 'method']);
Route::post('/practice-offer/get', [\App\Http\Controllers\PracticeOffer\GetController::class, 'method']);
Route::post('/practice-offer/edit', [\App\Http\Controllers\PracticeOffer\EditController::class, 'method']);
Route::post('/practice-offer/delete', [\App\Http\Controllers\PracticeOffer\DeleteController::class, 'method']);

Route::post('/contract/create', [\App\Http\Controllers\Contract\CreateController::class, 'method']);
Route::post('/contract/get', [\App\Http\Controllers\Contract\GetController::class, 'method']);
Route::post('/contract/get-file', [\App\Http\Controllers\Contract\GetFileController::class, 'method']);
Route::post('/contract/edit', [\App\Http\Controllers\Contract\EditController::class, 'method']);
Route::post('/contract/delete', [\App\Http\Controllers\Contract\DeleteController::class, 'method']);

Route::post('/ukf_employee/create', [\App\Http\Controllers\UKF_Employee\CreateController::class, 'method']);
Route::post('/ukf_employee/get', [\App\Http\Controllers\UKF_Employee\GetController::class, 'method']);
Route::post('/ukf_employee/edit', [\App\Http\Controllers\UKF_Employee\EditController::class, 'method']);
Route::post('/ukf_employee/delete', [\App\Http\Controllers\UKF_Employee\DeleteController::class, 'method']);
