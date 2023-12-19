<?php

use App\Http\Controllers\CompanyReview\CompanyReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeReport;
use App\Http\Controllers\Student;
use App\Http\Controllers\Agreement;
use App\Http\Controllers\Practice;
use App\Http\Controllers\StudyProgram;
use App\Http\Controllers\UKF_Employee;
use App\Http\Controllers\CompanyEmployee;
use App\Http\Controllers\PracticeReportUpload;
use App\Http\Controllers\StudentReview;
use App\Http\Controllers\UKF_Employee_Department;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great! -> we sure did
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
     *  Company (M)
     */
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/company/create", [\App\Http\Controllers\Company\CreateController::class, "method"]);
    Route::get("/company/get", [\App\Http\Controllers\Company\GetController::class, "method"]);
    Route::get("/company/get-all", [\App\Http\Controllers\Company\GetController::class, "method2"]);
    Route::get("/company/get-by-filter", [\App\Http\Controllers\Company\GetController::class, "method3"]);
    Route::get("/company/get-count", [\App\Http\Controllers\Company\GetController::class, "method4"]);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->patch("/company/edit", [\App\Http\Controllers\Company\EditController::class, "method"]);
    Route::middleware("auth:{$vars->admin}")->delete("/company/delete", [\App\Http\Controllers\Company\DeleteController::class, "method"]);


    /**
     *  Practice offer (M)
     */
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->post("/practice-offer/create", [\App\Http\Controllers\PracticeOffer\CreateController::class, "method"]);
    Route::get("/practice-offer/get", [\App\Http\Controllers\PracticeOffer\GetController::class, "method"]);
    Route::get("/practice-offer/get-all", [\App\Http\Controllers\PracticeOffer\GetController::class, "method2"]);
    Route::get("/practice-offer/get-by-filter", [\App\Http\Controllers\PracticeOffer\GetController::class, "method3"]);
    Route::get("/practice-offer/get-count", [\App\Http\Controllers\PracticeOffer\GetController::class, "method4"]);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->patch("/practice-offer/edit", [\App\Http\Controllers\PracticeOffer\EditController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->delete("/practice-offer/delete", [\App\Http\Controllers\PracticeOffer\DeleteController::class, "method"]);


    /**
     *  Contract (M)
     */
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/contract/create", [\App\Http\Controllers\Contract\CreateController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/contract/get", [\App\Http\Controllers\Contract\GetController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/contract/get-all", [\App\Http\Controllers\Contract\GetController::class, "method2"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/contract/get-by-filter", [\App\Http\Controllers\Contract\GetController::class, "method3"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/contract/get-count", [\App\Http\Controllers\Contract\GetController::class, "method4"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/contract/get-file", [\App\Http\Controllers\Contract\GetFileController::class, "method"]);
    Route::middleware("auth:{$vars->ukfEmployee}")->patch("/contract/edit", [\App\Http\Controllers\Contract\EditController::class, "method"]);
    Route::middleware("auth:{$vars->admin}")->delete("/contract/delete", [\App\Http\Controllers\Contract\DeleteController::class, "method"]);


    /**
     *  Student
     */
    Route::get("/student/get/", [Student\GetController::class, 'getStudentById']);
    Route::get("/student/get-by-email", [Student\GetController::class, 'getStudentByEmail']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/student/get-all-students", [Student\GetController::class, 'getAllStudents']);
    Route::middleware("auth:{$vars->admin},{$vars->ukfEmployee}")->post("/student/create", [Student\CreateController::class, 'createStudent']);
    Route::middleware("auth:{$vars->admin}")->post("/student/delete/", [Student\DeleteController::class, 'deleteStudent']);
    Route::middleware("auth:{$vars->admin},{$vars->ukfEmployee}")->patch("/student/edit", [Student\EditController::class, 'updateStudent']);
    Route::middleware("auth:{$vars->ukfEmployee}")->patch("/student/attachStudentToStudyProgram", [Student\EditController::class, 'attachStudentToStudyProgram']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->student}")->patch("/student/attachStudentToPracticeOffer", [Student\EditController::class, 'attachStudentToPracticeOffer']);


    /**
     *  Practice
     */
    Route::post("/practice/create", [Practice\CreateController::class, 'createPractice']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->patch("/practice/edit", [Practice\EditController::class, 'updatePractice']);
    Route::get("/practice/get", [Practice\GetController::class, 'getPracticeById']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->get("/practice/get-all", [Practice\GetController::class, 'getAllPractices']);
    Route::middleware("auth:{$vars->admin}")->delete("/practice/delete", [Practice\DeleteController::class, 'deletePractice']);


    /**
     * Study Program
     */
    Route::middleware("auth:{$vars->admin}")->post("study-program/create", [StudyProgram\StudyProgramController::class, 'createStudyProgram']);
    Route::get("study-program/get", [StudyProgram\StudyProgramController::class, 'getStudyProgram']);
    Route::get("study-program/get-all", [StudyProgram\StudyProgramController::class, 'getAllStudyPrograms']);
    Route::middleware("auth:{$vars->admin}")->delete("study-program/delete", [StudyProgram\StudyProgramController::class, 'deleteStudyProgram']);
    Route::middleware("auth:{$vars->admin}")->patch("study-program/edit", [StudyProgram\StudyProgramController::class, 'editStudyProgram']);


    /**
     * Company Review
     */
    Route::middleware("auth:{$vars->student}")->post("company-review/create", [CompanyReviewController::class, 'createCompanyReview']);
    Route::get("company-review/get", [CompanyReviewController::class, 'getCompanyReview']);
    Route::get("company-review/get-all", [CompanyReviewController::class, 'getAllCompanyReviews']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->student}")->patch("company-review/edit", [CompanyReviewController::class, 'editCompanyReview']);
    Route::middleware("auth:{$vars->admin}")->delete("company-review/delete", [CompanyReviewController::class, 'deleteCompanyReview']);


    /**
     * Company Employee
     */
    Route::middleware("auth:{$vars->student}")->post("/company_employee/create", [CompanyEmployee\CreateController::class, 'createCompanyEmployee']);
    Route::middleware("auth:{$vars->admin}")->post("/company_employee/create", [CompanyEmployee\CreateController::class, 'createCompanyEmployee']);
    Route::middleware("auth:{$vars->admin}")->patch("/company_employee/edit", [CompanyEmployee\EditController::class, 'updateCompanyEmployee']);
    Route::middleware("auth:{$vars->admin}")->delete("/company_employee/delete", [CompanyEmployee\DeleteController::class, 'deleteCompanyEmployee']);
    Route::get('/company_employee/get', [CompanyEmployee\GetController::class, 'getCompanyEmployeeById']);
    Route::get('/company_employee/get-by-filter', [CompanyEmployee\GetController::class, 'getCompanyEmployeeByFilter']);
    Route::get('/company_employee/get-all-ukf_employees', [CompanyEmployee\GetController::class, 'getAllCompanyEmployees']);


    /**
     * UKF Employee
     */
    Route::middleware("auth:{$vars->admin}")->post("/ukf_employee/create", [UKF_Employee\CreateController::class, 'createUKF_Employee']);
    Route::middleware("auth:{$vars->admin}")->patch("/ukf_employee/edit", [UKF_Employee\EditController::class, 'updateUKF_Employee']);
    Route::middleware("auth:{$vars->admin}")->delete("/ukf_employee/delete", [UKF_Employee\DeleteController::class, 'deleteUKF_Employee']);
    Route::get('/ukf_employee/get', [UKF_Employee\GetController::class, 'getUKF_EmployeeById']);
    Route::get('/ukf_employee/get-by-filter', [UKF_Employee\GetController::class, 'getUKF_EmployeeByFilter']);
    Route::get('/ukf_employee/get-all-ukf_employees', [UKF_Employee\GetController::class, 'getAllUKF_Employees']);


    /**
     * Practice Report Upload
     */
    Route::middleware("auth:{$vars->student}")->post("/practice_report_upload/create", [PracticeReportUpload\PracticeReportUploadController::class, 'createPracticeReportUpload']);
    Route::middleware("auth:{$vars->student}")->patch("/practice_report_upload/edit", [PracticeReportUpload\PracticeReportUploadController::class, 'editPracticeReportUpload']);
    Route::middleware("auth:{$vars->student}")->delete("/practice_report_upload/delete", [PracticeReportUpload\PracticeReportUploadController::class, 'deletePracticeReportUpload']);
    Route::middleware("auth:{$vars->admin}")->post("/practice_report_upload/create", [PracticeReportUpload\PracticeReportUploadController::class, 'createPracticeReportUpload']);
    Route::middleware("auth:{$vars->admin}")->patch("/practice_report_upload/edit", [PracticeReportUpload\PracticeReportUploadController::class, 'editPracticeReportUpload']);
    Route::middleware("auth:{$vars->admin}")->delete("/practice_report_upload/delete", [PracticeReportUpload\PracticeReportUploadController::class, 'deletePracticeReportUpload']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/practice_report_upload/get", [PracticeReportUpload\PracticeReportUploadController::class, 'getPracticeReportUploadById']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/practice_report_upload/get-all", [PracticeReportUpload\PracticeReportUploadController::class, 'getAllPracticeReportUploads']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/practice_report_upload/get-active", [PracticeReportUpload\PracticeReportUploadController::class, 'getActivePracticeUploads']);


    /**
     * Department
     */
    Route::middleware("auth:{$vars->admin}")->post('/department/create', [\App\Http\Controllers\Department\CreateController::class, 'createDepartment']);
    Route::get('/department/getAll', [\App\Http\Controllers\Department\GetController::class, 'getAllDepartments']);
    Route::get('/department/{id}/get', [\App\Http\Controllers\Department\GetController::class, 'getDepartmentById']);
    Route::middleware("auth:{$vars->admin}")->patch('/department/edit', [\App\Http\Controllers\Department\EditController::class, 'updateDepartment']);
    Route::middleware("auth:{$vars->admin}")->delete('/department/delete', [\App\Http\Controllers\Department\DeleteController::class, 'deleteDepartment']);


    /**
     *  Agreement
     */
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->student}")->post('/agreement/create', [Agreement\CreateController::class, 'createAgreement']);
    Route::middleware("auth:{$vars->ukfEmployee}")->patch('/agreement/edit', [Agreement\EditController::class, 'updateAgreement']);
    Route::middleware("auth:{$vars->ukfEmployee}")->delete('/agreement/delete', [Agreement\DeleteController::class, 'deleteAgreement']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee},{$vars->student}")->get('/agreement/get', [Agreement\GetController::class, 'getAgreementById']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get('/agreement/get-by-filter', [Agreement\GetController::class, 'getAgreementByFilter']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get('/agreement/get-all', [Agreement\GetController::class, 'getAllAgreements']);


    /**
     *  UKF_Employee_Department
     */
    Route::middleware("auth:{$vars->ukfEmployee}")->post('/ukf_employee_department/create', [UKF_Employee_Department\CreateController::class, 'createUKF_Employee_Department']);
    Route::middleware("auth:{$vars->ukfEmployee}")->patch('/ukf_employee_department/edit', [UKF_Employee_Department\EditController::class, 'updateUKF_Employee_Department']);
    Route::middleware("auth:{$vars->ukfEmployee}")->delete('/ukf_employee_department/delete', [UKF_Employee_Department\DeleteController::class, 'deleteUKF_Employee_Department']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee},{$vars->student}")->get('/ukf_employee_department/get', [UKF_Employee_Department\GetController::class, 'getUKF_Employee_DepartmentById']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get('/ukf_employee_department/get-by-filter', [UKF_Employee_Department\GetController::class, 'getUKF_Employee_DepartmentByFilter']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get('/ukf_employee_department/get-all', [UKF_Employee_Department\GetController::class, 'getAllUKF_employee_Department']);


    /**
     * Practice Report
     */
    Route::middleware("auth:{$vars->student}")->post("/practice_report/create", [PracticeReport\CreateController::class, 'createPracticeReport']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->get("/practice_report/{id}/get", [PracticeReport\GetController::class, 'getPracticeReportById']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get("/practice_report/getAll", [PracticeReport\GetController::class, 'getAllPracticeReports']);
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/practice_report/{id}/edit", [PracticeReport\EditController::class, 'updatePracticeReport']);
    Route::middleware("auth:{$vars->ukfEmployee}")->post("/practice_report/{id}/delete", [PracticeReport\DeleteController::class, 'deletePracticeReport']);


    /**
     * Student Review
     */
    Route::middleware("auth:{$vars->student}")->post('/student_review/create', [StudentReview\CreateController::class, 'createStudentReview']);
    Route::middleware("auth:{$vars->ukfEmployee},{$vars->companyEmployee}")->get('/student_review/{studentId}/{ukfEmployeeId}/get', [StudentReview\GetController::class, 'getStudentReviewById']);
    Route::middleware("auth:{$vars->ukfEmployee}")->get('/student_review/getAll', [StudentReview\GetController::class, 'getAllStudentReviews']);
    Route::middleware("auth:{$vars->ukfEmployee}")->post('/student_review/{studentId}/{ukfEmployeeId}/edit', [StudentReview\EditController::class, 'updateStudentReview']);
    Route::middleware("auth:{$vars->ukfEmployee}")->post('/student_review/{studentId}/{ukfEmployeeId}/delete', [StudentReview\DeleteController::class, 'deleteStudentReview']);


});
