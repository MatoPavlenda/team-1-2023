<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student;
use App\Http\Controllers\Practice;
use App\Http\Controllers\StudyProgram;
use App\Http\Controllers\UKF_Employee;
use App\Http\Controllers\CompanyEmployee;
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
    Route::get("/student/get-all-students", [Student\GetController::class, 'getAllStudents']);
    Route::post("/student/create", [Student\CreateController::class, 'createStudent']);
    Route::post("/student/delete/", [Student\DeleteController::class, 'deleteStudent']);
    Route::patch("/student/edit", [Student\EditController::class, 'updateStudent']);

    /**
     *  Practice
     */
    Route::post('/practice/create', [Practice\CreateController::class, 'createPractice']);
    Route::patch('/practice/edit', [Practice\EditController::class, 'updatePractice']);
    Route::get('/practice/get', [Practice\GetController::class, 'getPracticeById']);
    Route::get('/practice/get-all', [Practice\GetController::class, 'getAllPractices']);
    Route::delete('/practice/delete', [Practice\DeleteController::class, 'deletePractice']);



});

Route::post("study-program/create", [StudyProgram\StudyProgramController::class, 'createStudyProgram']);
Route::get("study-program/get", [StudyProgram\StudyProgramController::class, 'getStudyProgram']);
Route::get("study-program/get-all", [StudyProgram\StudyProgramController::class, 'getAllStudyPrograms']);
Route::delete("study-program/delete", [StudyProgram\StudyProgramController::class, 'deleteStudyProgram']);
Route::patch("study-program/patch", [StudyProgram\StudyProgramController::class, 'editStudyProgram']);



/**
 *  UKF Employee
 */
Route::post('/ukf_employee/create', [UKF_Employee\CreateController::class, 'createUKF_Employee']);
Route::post('/ukf_employee/edit', [UKF_Employee\EditController::class, 'updateUKF_Employee']);
Route::post('/ukf_employee/delete', [UKF_Employee\DeleteController::class, 'deleteUKF_Employee']);
Route::get('/ukf_employee/get', [UKF_Employee\GetController::class, 'getUKF_EmployeeById']);
Route::get('/ukf_employee/get-by-name', [UKF_Employee\GetController::class, 'getUKF_EmployeeByName']);
Route::get('/ukf_employee/get-by-surname', [UKF_Employee\GetController::class, 'getUKF_EmployeeBySurname']);
Route::get('/ukf_employee/get-by-fullname', [UKF_Employee\GetController::class, 'getUKF_EmployeeByFullName']);
Route::get('/ukf_employee/get-all-ukf_employees', [UKF_Employee\GetController::class, 'getAllUKF_Employees']);

/**
 *  Company Employee
 */
Route::post('/company_employee/create', [CompanyEmployee\CreateController::class, 'createCompanyEmployee']);
Route::post('/company_employee/edit', [CompanyEmployee\EditController::class, 'updateCompanyEmployee']);
Route::post('/company_employee/delete', [CompanyEmployee\DeleteController::class, 'deleteCompanyEmployee']);
Route::get('/company_employee/get', [CompanyEmployee\GetController::class, 'getCompanyEmployeeById']);
Route::get('/company_employee/get-by-name', [CompanyEmployee\GetController::class, 'getCompanyEmployeeByName']);
Route::get('/company_employee/get-by-surname', [CompanyEmployee\GetController::class, 'getCompanyEmployeeBySurname']);
Route::get('/company_employee/get-by-fullname', [CompanyEmployee\GetController::class, 'getCompanyEmployeeByFullName']);
Route::get('/company_employee/get-all-ukf_employees', [CompanyEmployee\GetController::class, 'getAllCompanyEmployees']);
Route::get('/company_employee/get-by-position', [CompanyEmployee\GetController::class, 'getCompanyEmployeeByPosition']);
Route::get('/company_employee/get-by-email', [CompanyEmployee\GetController::class, 'getCompanyEmployeeByEmail']);
Route::get('/company_employee/get-by-company_name', [CompanyEmployee\GetController::class, 'getCompanyEmployeeByCompanyName']);
Route::get('/company_employee/get-by-company_name_and_position', [CompanyEmployee\GetController::class, 'getCompanyEmployeeByCompanyAndPosition']);

