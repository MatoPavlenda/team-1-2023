<?php


namespace App\Http\Controllers\UKF_Employee_Department;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee_Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;

class EditController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function updateUKF_Employee_Department(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ukf_employee_id' => 'sometimes|exists:ukf_employee,id',
            'department_id' => 'sometimes|exists:department,id',
            'd_sdate' => 'sometimes|date_format:Y-m-d',
            'd_edate' => 'sometimes|date_format:Y-m-d',
            's_active' => 'sometimes|integer|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        // Find the UKF_Employee_Department by ID
        $id = $request->input('id');
        $ukf_employee_department = UKF_Employee_Department::find($id);
        if (!$ukf_employee_department) {
            return $this->responseService->createErrorResponse("UKF_Employee_Department with id " . $id . " not found.");
        }

        // Update the UKF_Employee_Department with validated data
        $ukf_employee_department->update($validator->validated());

        return $this->responseService->createSuccessfulResponse("UKF_Employee_Department updated successfully");
    }
}
