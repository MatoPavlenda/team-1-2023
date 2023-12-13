<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student;
use App\Http\Controllers\Practice;
use App\Http\Controllers\StudyProgram;


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

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

/**
 * Authentificaiton
 */
Route::post("/login", [\App\Http\Controllers\Authentication\AuthController::class, "login"]);

Route::middleware(["auth"])->group(function () {
    $vars = new \App\Variables();
    /**
     *  Company
     */
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/company/create", [\App\Http\Controllers\Company\CreateController::class, "method"]);
    Route::post("/company/get", [\App\Http\Controllers\Company\GetController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->post("/company/edit", [\App\Http\Controllers\Company\EditController::class, "method"]);
    Route::middleware("auth:{$vars->admin}")->post("/company/delete", [\App\Http\Controllers\Company\DeleteController::class, "method"]);


    /**
     *  Practice offer
     */
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->post("/practice-offer/create", [\App\Http\Controllers\PracticeOffer\CreateController::class, "method"]);
    Route::post("/practice-offer/get", [\App\Http\Controllers\PracticeOffer\GetController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->post("/practice-offer/edit", [\App\Http\Controllers\PracticeOffer\EditController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->post("/practice-offer/delete", [\App\Http\Controllers\PracticeOffer\DeleteController::class, "method"]);


    /**
     *  Contract
     */
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/contract/create", [\App\Http\Controllers\Contract\CreateController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/contract/get", [\App\Http\Controllers\Contract\GetController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/contract/get-file", [\App\Http\Controllers\Contract\GetFileController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/contract/edit", [\App\Http\Controllers\Contract\EditController::class, "method"]);
    Route::middleware("auth:{$vars->admin}")->post("/contract/delete", [\App\Http\Controllers\Contract\DeleteController::class, "method"]);


    /**
     *  Student
     */
    Route::get("/student/get/", [Student\GetController::class, 'getStudentById']);
    Route::get("/student/get-by-email", [Student\GetController::class, 'getStudentByEmail']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/student/get-all-students", [Student\GetController::class, 'getAllStudents']);
    //TODO spytat sa ze ako creatnut studenta - ci to nespravi login
    Route::middleware("auth:{$vars->admin}")->post("/student/create", [Student\CreateController::class, 'createStudent']);
    Route::middleware("auth:{$vars->admin}")->post("/student/delete/", [Student\DeleteController::class, 'deleteStudent']);
    Route::middleware("auth:{$vars->admin}")->patch("/student/edit", [Student\EditController::class, 'updateStudent']);

    /**
     *  Practice
     */
    Route::post("/practice/create", [Practice\CreateController::class, 'createPractice']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->patch("/practice/edit", [Practice\EditController::class, 'updatePractice']);
    Route::get("/practice/get", [Practice\GetController::class, 'getPracticeById']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->get("/practice/get-all", [Practice\GetController::class, 'getAllPractices']);
    Route::middleware("auth:{$vars->admin}")->delete("/practice/delete", [Practice\DeleteController::class, 'deletePractice']);


});

Route::post("study-program/create", [StudyProgram\StudyProgramController::class, 'createStudyProgram']);
Route::get("study-program/get", [StudyProgram\StudyProgramController::class, 'getStudyProgram']);
Route::get("study-program/get-all", [StudyProgram\StudyProgramController::class, 'getAllStudyPrograms']);
Route::delete("study-program/delete", [StudyProgram\StudyProgramController::class, 'deleteStudyProgram']);
Route::patch("study-program/patch", [StudyProgram\StudyProgramController::class, 'editStudyProgram']);



/*
 * Department
 */
Route::post('/department/create', [\App\Http\Controllers\Department\CreateController::class, 'createDepartment']);
Route::get('/department/getAll', [\App\Http\Controllers\Department\GetController::class, 'getAllDepartments']);
Route::get('/department/{id}/get', [\App\Http\Controllers\Department\GetController::class, 'getDepartmentById']);
Route::post('/department/{id}/edit', [\App\Http\Controllers\Department\EditController::class, 'updateDepartment']);
Route::post('/department/{id}/delete', [\App\Http\Controllers\Department\DeleteController::class, 'deleteDepartment']);
