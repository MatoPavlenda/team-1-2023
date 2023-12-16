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

    public function getCompanyEmployeeByEmail(Request $request)
    {
        $email = $request->input('email');
        $company_employee = CompanyEmployee::WHERE('email', "=", $email)->first();
        if($company_employee){
            return $this->responseService->createDataResponse($company_employee);
        } else {
            return $this->responseService->createErrorResponse("Company Employee with email " . $email . " not found");
        }
    }

    public function getCompanyEmployeeByFullName(Request $request)
    {
        $name = $request->input('name');
        $surname = $request->input('surname');

        $company_employee = CompanyEmployee::where('name', $name)
            ->where('surname', $surname)
            ->first();

        if ($company_employee) {
            return $this->responseService->createDataResponse($company_employee);
        } else {
            $errorMessage = "Company Employee with name " . $name . " and surname " . $surname . " not found";
            return $this->responseService->createErrorResponse($errorMessage);
        }
    }

    public function getCompanyEmployeeByName(Request $request)
    {
        $name = $request->input('name');
        $company_employee = CompanyEmployee::where('name', $name)->get();
        if($company_employee){
            return $this->responseService->createDataResponse($company_employee);
        } else {
            return $this->responseService->createErrorResponse("Company Employee with name " . $name . " not found");
        }
    }

    public function getCompanyEmployeeBySurname(Request $request)
    {
        $surname = $request->input('surname');
        $company_employee= CompanyEmployee::where('surname', $surname)->get();

        if($company_employee){
            return $this->responseService->createDataResponse($company_employee);
        } else {
            return $this->responseService->createErrorResponse("Company Employee with surname " . $surname . " not found");
        }
    }


    public function getCompanyEmployeeByPosition(Request $request)
    {
        $position= $request->input('position');
        $company_employee = CompanyEmployee::where('position', $position)->get();

        if($company_employee){
            return $this->responseService->createDataResponse($company_employee);
        } else {
            return $this->responseService->createErrorResponse("Company Employee with position " . $position . " not found");
        }
    }


    public function getCompanyEmployeeByCompanyName(Request $request)
    {
        $companyName = $request->input('company_name');

        // Najdi ID firmy na základe názvu
        $companyId = Company::where('name', $companyName)->value('id');

        if (!$companyId) {
            return $this->responseService->createErrorResponse("Company with name " . $companyName . " not found");
        }

        // Company Employee na základe ID firmy
        $companyEmployees = CompanyEmployee::where('company_id', $companyId)->get();

        return $this->responseService->createDataResponse($companyEmployees);
    }

    public function getCompanyEmployeeByCompanyAndPosition(Request $request)
    {
        $companyName = $request->input('company_name');
        $position = $request->input('position');

        // Nájdi ID firmy na základe názvu
        $companyId = Company::where('name', $companyName)->value('id');

        if (!$companyId) {
            return $this->responseService->createErrorResponse("Company with name " . $companyName . " not found");
        }

        // Company Employee na základe ID firmy a pozície
        $companyEmployees = CompanyEmployee::where('company_id', $companyId)
            ->where('position', $position)
            ->get();

        if ($companyEmployees->isNotEmpty()) {
            return $this->responseService->createDataResponse($companyEmployees);
        } else {
            $errorMessage = "Company Employee with position " . $position . " in company " . $companyName . " not found";
            return $this->responseService->createErrorResponse($errorMessage);
        }
    }

    public function getAllCompanyEmployees(){
        $company_employees = CompanyEmployee::all();
        return $this->responseService->createDataResponse($company_employees);
    }


}
