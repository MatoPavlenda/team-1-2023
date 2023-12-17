<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student;
use App\Http\Controllers\Agreement;


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


/*
 * Department
 */
Route::post('/department/create', [\App\Http\Controllers\Department\CreateController::class, 'createDepartment']);
Route::get('/department/getAll', [\App\Http\Controllers\Department\GetController::class, 'getAllDepartments']);
Route::get('/department/{id}/get', [\App\Http\Controllers\Department\GetController::class, 'getDepartmentById']);
Route::post('/department/{id}/edit', [\App\Http\Controllers\Department\EditController::class, 'updateDepartment']);
Route::post('/department/{id}/delete', [\App\Http\Controllers\Department\DeleteController::class, 'deleteDepartment']);


/**
 *  Agreement
 */
Route::post('/agreement/create', [Agreement\CreateController::class, 'createAgreement']);
Route::post('/agreement/edit', [Agreement\EditController::class, 'updateAgreement']);
Route::post('/agreement/delete', [Agreement\DeleteController::class, 'deleteAgreement']);
Route::get('/agreement/get', [Agreement\GetController::class, 'getAgreement']);


