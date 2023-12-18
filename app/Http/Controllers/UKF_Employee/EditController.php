<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;
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

    public function updateUKF_Employee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:50',
            'surname' => 'sometimes|string|max:50',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        // Find the UKF_employee by ID
        $id = $request->input('id');
        $ukf_employee = UKF_Employee::find($id);
        if (!$ukf_employee) {
            return $this->responseService->createErrorResponse("UKF Employee with id " .$id . " not found.");
        }

        // Update the UKF_Employee with validated data
        $ukf_employee->update($validator->validated());

        return $this->responseService->createSuccessfulResponse("UKF Employee updated successfully");
    }
}
