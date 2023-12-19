<?php


namespace App\Http\Controllers\UKF_Employee_Department;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee_Department;
use App\Models\Student;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\UKF_Employee;
use App\Models\Department;


class GetController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getUKF_Employee_DepartmentById(Request $request)
    {
        $id = $request->input('id');

        $ukf_employee_department = UKF_Employee_Department::find($id);
        if ($ukf_employee_department) {
            return $this->responseService->createDataResponse($ukf_employee_department);
        } else {
            return $this->responseService->createErrorResponse("UKF_Employee_Department with id " . $id . " not found");
        }
    }

    public function getUKF_Employee_DepartmentByFilter(Request $request)
    {
        $query = UKF_Employee_Department::query();

        // Filter by active
        if ($request->has('s_active')) {
            $s_active = $request->input('s_active');
            $query->where('s_active', '=', $s_active);
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
        // Filter by department
        if ($request->has('department_title')) {
            $departmentTitle = $request->input('department_title');

            // Find department ID based on title
            $departmentId = Department::where('title', $departmentTitle)->value('id');

            if ($departmentId) {
                $query->where('department_id', $departmentId);
            } else {
                return $this->responseService->createErrorResponse("Department with title " . $departmentTitle . " not found");
            }
        }

        $ukfEmployeeDepartment = $query->get();

        if ($ukfEmployeeDepartment->isNotEmpty()) {
            return $this->responseService->createDataResponse($ukfEmployeeDepartment);
        } else {
            return $this->responseService->createErrorResponse("No ukfEmployeeDepartment found with the specified filters");
        }
    }


    public function getAllUKF_employee_Department()
    {
        $ukf_employee_department = UKF_employee_Department::all();
        return $this->responseService->createDataResponse($ukf_employee_department);
    }
}
