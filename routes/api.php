<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UKF_Employee;
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

/*
  UKF Employee
 */
Route::post('/ukf_employee/create', [\App\Http\Controllers\UKF_Employee\CreateController::class, 'createUKF_Employee']);
Route::get('/ukf_employee/getAllUKF_Employees', [\App\Http\Controllers\UKF_Employee\GetController::class, 'getAllUKF_Employees']);
Route::get('/ukf_employee/{id}/get', [\App\Http\Controllers\UKF_Employee\GetController::class, 'getUKF_EmployeeById']);
Route::get('/ukf_employee/getByEmail/{email}', [\App\Http\Controllers\UKF_Employee\GetController::class, 'getUKF_EmployeeByEmail']);
Route::get('/ukf_employee/getByFullName/{name}/{surname}', [\App\Http\Controllers\UKF_Employee\GetController::class, 'getUKF_EmployeeByFullName']);
Route::get('/ukf_employee/getByName/{name}', [\App\Http\Controllers\UKF_Employee\GetController::class, 'getUKF_EmployeeByName']);
Route::get('/ukf_employee/getBySurname/{surname}', [\App\Http\Controllers\UKF_Employee\GetController::class, 'getUKF_EmployeeBySurname']);
Route::post('/ukf_employee/{id}/edit', [\App\Http\Controllers\UKF_Employee\EditController::class, 'updateUKF_Employee']);
Route::post('/ukf_employee/{id}/delete', [\App\Http\Controllers\UKF_Employee\DeleteController::class, 'deleteUKF_Employee']);

/*
  Company Employee
 */
Route::post('/company_employee/create', [\App\Http\Controllers\CompanyEmployee\CreateController::class, 'createCompanyEmployee']);
Route::post('/company_employee/{id}/edit', [\App\Http\Controllers\CompanyEmployee\EditController::class, 'updateCompanyEmployee']);
Route::post('/company_employee/{id}/delete', [\App\Http\Controllers\CompanyEmployee\DeleteController::class, 'deleteCompanyEmployee']);
Route::get('/company_employee/{id}/get', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getCompanyEmployeeById']);
Route::get('/company_employee/getByEmail/{email}', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getCompanyEmployeeByEmail']);
Route::get('/company_employee/getByFullName/{name}/{surname}', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getCompanyEmployeeByFullName']);
Route::get('/company_employee/getByName/{name}', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getCompanyEmployeeByName']);
Route::get('/company_employee/getBySurname/{surname}', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getCompanyEmployeeBySurname']);
Route::get('/company_employee/getByCompanyName/{companyName}', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getCompanyEmployeeByCompanyName']);
Route::get('/company_employee/getByPosition/{position}', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getCompanyEmployeeByPosition']);
Route::get('/company_employee/getByCompanyAndPosition/{companyName}/{position}', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getCompanyEmployeeByCompanyAndPosition']);
Route::get('/company_employee/getAll', [\App\Http\Controllers\CompanyEmployee\GetController::class, 'getAllCompanyEmployees']);
