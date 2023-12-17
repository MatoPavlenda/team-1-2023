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

            'i_id_company' => 'required|exists:i_id_company',
            'i_id_student' => 'required|exists:i_id_student',
            'i_id_ukf_employee' => 'required|exists:i_id_ukf_employee',
            't_url' => 'required|string|max:255',
            'd_sdate' => 'required|date_format:Y-m-d',
            'd_edate' => 'required|date_format:Y-m-d',
            'd_cdate' => 'required|date_format:Y-m-d',
            's_active' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $agreement = Agreement::create($validatedData);

        return $this->responseService->createSuccessfulResponse($agreement);
    }
}
