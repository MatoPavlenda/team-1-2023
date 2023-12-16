<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
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

