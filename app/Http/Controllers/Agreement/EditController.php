<?php

namespace App\Http\Controllers\Agreement;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
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

    public function updateAgreement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'sometimes|exists:company_id',
            'student_id' => 'sometimes|exists:student_id',
            'ukf_employee_id' => 'sometimes|exists:ukf_employee_id',
            't_url-' => 'sometimes|string|max:300',
            'd_sdate' => 'sometimes|date_format:Y-m-d',
            'd_edate' => 'sometimes|date_format:Y-m-d',
            'd_cdate' => 'sometimes|date_format:Y-m-d',
            's_active' => 'sometimes|integer|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        // Find the Agreement by ID
        $id = $request->input('id');
        $agreement= Agreement::find($id);
        if (!$agreement) {
            return $this->responseService->createErrorResponse("Agreement with id " .$id . " not found.");
        }

        // Update the Agreement with validated data
        $agreement->update($validator->validated());

        return $this->responseService->createSuccessfulResponse("Agreement updated successfully");
    }
}
