<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;
use App\Services\ResponseService;
use Illuminate\Http\Request;


class GetController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getUKF_EmployeeById(Request $request)
    {
        $id = $request->input('id');

        $ukf_employee = UKF_Employee::find($id);
        if($ukf_employee){
            return  $this->responseService->createDataResponse($ukf_employee);

        } else {
            return $this->responseService->createErrorResponse("UKF Employee with id ".$id. " not found");
        }
    }



    public function getUKF_EmployeeByFullName(Request $request)
    {
        $name = $request->input('name');
        $surname = $request->input('surname');

        $ukf_employee = UKF_Employee::where('name', '=', $name)
            ->where('surname', '=', $surname)
            ->first();

        if ($ukf_employee) {
            return $this->responseService->createDataResponse($ukf_employee);
        } else {
            $errorMessage = "UKF Employee with name " . $name . " and surname " . $surname . " not found";
            return $this->responseService->createErrorResponse($errorMessage);
        }
    }

    public function getUKF_EmployeeByName(Request $request)
    {
        $name = $request->input('name');
        $ukf_employee = UKF_Employee::WHERE('name', "=", $name)->first();
        if($ukf_employee){
            return $this->responseService->createDataResponse($ukf_employee);
        } else {
            return $this->responseService->createErrorResponse("UKF Employee with name " . $name . " not found");
        }
    }

    public function getUKF_EmployeeBySurname(Request $request)
    {
        $surname = $request->input('surname');
        $ukf_employee = UKF_Employee::WHERE('surname', "=", $surname)->first();
        if($ukf_employee){
            return $this->responseService->createDataResponse($ukf_employee);
        } else {
            return $this->responseService->createErrorResponse("UKF Employee with surname " . $surname . " not found");
        }
    }

    public function getAllUKF_Employees(){
        $ukf_employees = UKF_Employee::all();
        return $this->responseService->createDataResponse($ukf_employees);
    }


}
