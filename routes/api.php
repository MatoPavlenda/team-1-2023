<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PractiseReport;
use App\Http\Controllers\Student;
use App\Http\Controllers\Practice;

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

/**
 *  Company
 */
Route::get('/lol/{name}', [TestController::class, 'testMethod']);
Route::get('/test/{name?}', [TestController::class, 'covidMethod']);
Route::get('/overkill', [TestController::class, 'overkillMethod']);
Route::post('/save-student', [TestController::class, 'saveStudent']);

Route::post('/company/create', [\App\Http\Controllers\Company\CreateController::class, 'method']);
Route::post('/company/get', [\App\Http\Controllers\Company\GetController::class, 'method']);
Route::post('/company/edit', [\App\Http\Controllers\Company\EditController::class, 'method']);
Route::post('/company/delete', [\App\Http\Controllers\Company\DeleteController::class, 'method']);


/**
 *  Practice offer
 */
Route::post('/practice-offer/create', [\App\Http\Controllers\PracticeOffer\CreateController::class, 'method']);
Route::post('/practice-offer/get', [\App\Http\Controllers\PracticeOffer\GetController::class, 'method']);
Route::post('/practice-offer/edit', [\App\Http\Controllers\PracticeOffer\EditController::class, 'method']);
Route::post('/practice-offer/delete', [\App\Http\Controllers\PracticeOffer\DeleteController::class, 'method']);


/**
 *  Contract
 */
Route::post('/contract/create', [\App\Http\Controllers\Contract\CreateController::class, 'method']);
Route::post('/contract/get', [\App\Http\Controllers\Contract\GetController::class, 'method']);
Route::post('/contract/get-file', [\App\Http\Controllers\Contract\GetFileController::class, 'method']);
Route::post('/contract/edit', [\App\Http\Controllers\Contract\EditController::class, 'method']);
Route::post('/contract/delete', [\App\Http\Controllers\Contract\DeleteController::class, 'method']);


/**
 *  Student
 */
Route::get('/student/{id}/get/', [Student\GetController::class, 'getStudentById']);
Route::get('/student/getByEmail/{email}', [Student\GetController::class, 'getStudentByEmail']);
Route::get('/student/getAllStudents', [Student\GetController::class, 'getAllStudents']);
Route::post('/student/create', [Student\CreateController::class, 'createStudent']);
Route::post('/student/{id}/delete/', [Student\DeleteController::class, 'deleteStudent']);
Route::patch('/student/{id}/edit', [Student\EditController::class, 'updateStudent']);


/**
 *  Practice
 */
Route::post('/practice/create', [Practice\CreateController::class, 'createPractice']);
Route::post('/practice/{id}/edit', [Practice\EditController::class, 'updatePractice']);


/**
 *  Practise report
 */
Route::post('/practise-report/create', [PractiseReport\CreateController::class, 'createPractiseReport']);
Route::get('/practise-report/{id}/get', [PractiseReport\GetController::class, 'getPractiseReportById']);
Route::get('/practise-report/getAll', [PractiseReport\GetController::class, 'getAllPractiseReports']);
Route::post('/practise-report/{id}/edit', [PractiseReport\EditController::class, 'updatePractiseReport']);
Route::post('/practise-report/{id}/delete', [PractiseReport\DeleteController::class, 'deletePractiseReport']);
