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



    public function getUKF_EmployeeByFilter(Request $request)
    {
        $query = UKF_Employee::query();

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

        $ukfEmployees = $query->get();

        if ($ukfEmployees->isNotEmpty()) {
            return $this->responseService->createDataResponse($ukfEmployees);
        } else {
            return $this->responseService->createErrorResponse("No UKF Employees found with the specified filters");
        }
    }

    public function getAllUKF_Employees(){
        $ukf_employees = UKF_Employee::all();
        return $this->responseService->createDataResponse($ukf_employees);
    }


}
