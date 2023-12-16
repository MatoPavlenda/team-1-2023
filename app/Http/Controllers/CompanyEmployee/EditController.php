<?php

namespace App\Http\Controllers\CompanyEmployee;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;
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

    public function updateCompanyEmployee(Request $request)
    {
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:50',
            'surname' => 'sometimes|string|max:50',
            'email' => 'sometimes|string|email|max:255|unique:company_employee,email,' . $id,
            'position' => 'sometimes|string|max:50',
            'company_id' => 'sometimes|exists:company,id'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        // Find the CompanyEmployee by ID
        $company_employee = CompanyEmployee::find($id);
        if (!$company_employee) {
            return $this->responseService->createErrorResponse("Company Employee with id " .$id . " not found.");
        }

        // Update the CompanyEmployee with validated data
        $company_employee->update($validator->validated());

        return $this->responseService->createSuccessfulResponse("Company Employee updated successfully");
    }
}
