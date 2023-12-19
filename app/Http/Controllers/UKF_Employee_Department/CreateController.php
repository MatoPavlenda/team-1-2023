<?php


namespace App\Http\Controllers\UKF_Employee_Department;
use App\Http\Controllers\Controller;
use App\Models\UKF_Employee_Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;

class CreateController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function createUKF_Employee_Department(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ukf_employee_id' => 'required|exists:ukf_employee,id',
            'department_id' => 'required|exists:department,id',
            'd_sdate' => 'required|date_format:Y-m-d',
            'd_edate' => 'required|date_format:Y-m-d',
            's_active' => 'required|integer|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $ukf_employee_department = UKF_Employee_Department::create($validatedData);

        return $this->responseService->createSuccessfulResponse($ukf_employee_department);
    }
}
