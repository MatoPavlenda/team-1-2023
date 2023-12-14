<?php

namespace App\Http\Controllers\CompanyEmployee;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;
use App\Models\Company;


class GetController extends Controller
{

    public function getCompanyEmployeeById(int $id)
    {
        $company_employee = CompanyEmployee::find($id);
        if ($company_employee) {
            return response()->json($company_employee);
        } else {
            return response()->json("Company Employee with id " . $id . " not found", 404);
        }
    }

    public function getCompanyEmployeeByEmail(String $email)
    {
        $company_employee = CompanyEmployee::WHERE('email', "=", $email)->first();
        if($company_employee){
            return response()->json($company_employee);
        } else {
            return response()->json("Company Employee with email " . $email . " not found", 404);
        }
    }

    public function getCompanyEmployeeByFullName(String $name, String $surname)
    {
        $company_employee = CompanyEmployee::where('name', $name)
            ->where('surname', $surname)
            ->first();

        if ($company_employee) {
            return response()->json($company_employee);
        } else {
            return response()->json("Company Employee with name " . $name . " and surname " . $surname . " not found", 404);
        }
    }

    public function getCompanyEmployeeByName(String $name)
    {
        $company_employee = CompanyEmployee::where('name', $name)->get();

        if ($company_employee->isNotEmpty()) {
            return response()->json($company_employee);
        } else {
            return response()->json("Company Employee with name " . $name . " not found", 404);
        }
    }

    public function getCompanyEmployeeBySurname(String $surname)
    {
        $company_employee= CompanyEmployee::where('surname', $surname)->get();

        if ($company_employee->isNotEmpty()) {
            return response()->json($company_employee);
        } else {
            return response()->json("Company Employee with surname " . $surname . " not found", 404);
        }
    }

    public function getCompanyEmployeeByCompanyName(String $companyName)
    {
        // Najdi ID firmy na základe názvu
        $companyId = Company::where('name', $companyName)->value('id');

        if (!$companyId) {
            return response()->json("Company with name " . $companyName . " not found", 404);
        }

        // Company Employee na základe ID firmy
        $companyEmployees = CompanyEmployee::where('company_id', $companyId)->get();

        return response()->json($companyEmployees);
    }

    public function getCompanyEmployeeByPosition(String $position)
    {
        $company_employee = CompanyEmployee::where('position', $position)->get();

        if ($company_employee->isNotEmpty()) {
            return response()->json($company_employee);
        } else {
            return response()->json("Company Employee with position " . $position . " not found", 404);
        }
    }

    public function getCompanyEmployeeByCompanyAndPosition(String $companyName, String $position)
    {
        // Nájdi ID firmy na základe názvu
        $companyId = Company::where('name', $companyName)->value('id');

        if (!$companyId) {
            return response()->json("Company with name " . $companyName . " not found", 404);
        }

        // Company Employee na základe ID firmy a pozície
        $companyEmployees = CompanyEmployee::where('company_id', $companyId)
            ->where('position', $position)
            ->get();

        if ($companyEmployees->isNotEmpty()) {
            return response()->json($companyEmployees);
        } else {
            return response()->json("Company Employee with position " . $position . " in company " . $companyName . " not found", 404);
        }
    }

    public function getAllCompanyEmployees(){
        $company_employees = CompanyEmployee::all();
        return response()->json($company_employees);
    }


}
