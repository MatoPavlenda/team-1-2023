<?php

namespace App\Http\Controllers\Agreement;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Student;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\UKF_Employee;


class GetController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getAgreementById(Request $request)
    {
        $id = $request->input('id');

        $agreement = Agreement::find($id);
        if ($agreement) {
            return $this->responseService->createDataResponse($agreement);
        } else {
            return $this->responseService->createErrorResponse("Agreement with id " . $id . " not found");
        }
    }

    public function getAgreementByFilter(Request $request)
    {
        $query = Agreement::query();

        // Filter by active
        if ($request->has('s_active')) {
            $s_active = $request->input('s_active');
            $query->where('s_active', '=', $s_active);
        }


        // Filter by company name
        if ($request->has('company_name')) {
            $companyName = $request->input('company_name');

            // Find company ID based on name
            $companyId = Company::where('name', $companyName)->value('id');

            if ($companyId) {
                $query->where('company_id', $companyId);
            } else {
                return $this->responseService->createErrorResponse("Company with name " . $companyName . " not found");
            }
        }

        // Filter by student name
        if ($request->has('student_name')) {
            $studentName = $request->input('student_name');

            // Find company ID based on name
            $studentId = Student::where('name', $studentName)->value('id');

            if ($studentId) {
                $query->where('student_id', $studentId);
            } else {
                return $this->responseService->createErrorResponse("Student with name " . $studentName . " not found");
            }
        }

        // Filter by ukf_employee name
        if ($request->has('UKF_employee_name')) {
            $UKF_employeeName = $request->input('UKF_employee_name');

            // Find company ID based on name
            $UKF_employeeId = UKF_Employee::where('name', $$UKF_employeeName)->value('id');

            if ($UKF_employeeId) {
                $query->where('ukf_employee_id', $UKF_employeeId);
            } else {
                return $this->responseService->createErrorResponse("UKF employee with name " . $UKF_employeeName . " not found");
            }
        }

        $companyEmployees = $query->get();

        if ($companyEmployees->isNotEmpty()) {
            return $this->responseService->createDataResponse($companyEmployees);
        } else {
            return $this->responseService->createErrorResponse("No Company Employees found with the specified filters");
        }
    }


    public function getAllAgreements()
    {
        $agreements = Agreement::all();
        return $this->responseService->createDataResponse($agreements);
    }
}
