<?php

namespace App\Http\Controllers\Agreement;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
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

    public function createAgreement(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'company_id' => 'required|exists:company,id',
            'student_id' => 'required|exists:student,id',
            'ukf_employee_id' => 'required|exists:ukf_employee,id',
            't_url-' => 'sometimes|string|max:300',
            'd_sdate' => 'required|date_format:Y-m-d',
            'd_edate' => 'required|date_format:Y-m-d',
            'd_cdate' => 'required|date_format:Y-m-d',
            's_active' => 'required|integer|max:255',

        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $agreement = Agreement::create($validatedData);

        return $this->responseService->createSuccessfulResponse($agreement);
    }
}
