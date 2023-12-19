<?php


namespace App\Http\Controllers\UKF_Employee_Department;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee_Department;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function deleteUKF_Employee_Department(Request $request)
    {
        $id = $request->input('id');
        $ukf_employee_department = UKF_Employee_Department::find($id);
        if ($ukf_employee_department) {
            $ukf_employee_department->delete();
            return $this->responseService->createSuccessfulResponse("UKF_Employee_Department with id " . $id . " deleted");
        } else {
            return $this->responseService->createErrorResponse("UKF_Employee_Department with id " . $id . " not found");
        }
    }
}
