<?php

namespace App\Http\Controllers\CompanyEmployee;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;
use App\Models\Company;
use App\Services\ResponseService;
use Illuminate\Http\Request;


class GetController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getCompanyEmployeeById(Request $request)
    {
        $id = $request->input('id');
        $company_employee = CompanyEmployee::find($id);
        if ($company_employee) {
            return  $this->responseService->createDataResponse($company_employee);
        } else {
            return $this->responseService->createErrorResponse("Company Employee with id ".$id. " not found");
        }
    }

    public function getCompanyEmployeeByFilter(Request $request)
    {
        $query = CompanyEmployee::query();

        // Filter by email
        if ($request->has('email')) {
            $email = $request->input('email');
            $query->where('email', '=', $email);
        }

        // Filter by full name
        if ($request->has('name') && $request->has('surname')) {
            $name = $request->input('name');
            $surname = $request->input('surname');
            $query->where('name', $name)->where('surname', $surname);
        }

        // Filter by name
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('name', 'like', '%' . $name . '%');
        }

        // Filter by surname
        if ($request->has('surname')) {
            $surname = $request->input('surname');
            $query->where('surname', 'like', '%' . $surname . '%');
        }

        // Filter by position
        if ($request->has('position')) {
            $position = $request->input('position');
            $query->where('position', $position);
        }

        if ($request->has('admin')) {
            $admin = $request->input('admin');
            $query->where('admin', '=', $admin);
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

        $companyEmployees = $query->get();

        if ($companyEmployees->isNotEmpty()) {
            return $this->responseService->createDataResponse($companyEmployees);
        } else {
            return $this->responseService->createErrorResponse("No Company Employees found with the specified filters");
        }
    }

    public function getAllCompanyEmployees(){
        $company_employees = CompanyEmployee::all();
        return $this->responseService->createDataResponse($company_employees);
    }



}
