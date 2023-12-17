<?php

namespace App\Http\Controllers\Agreement;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GetController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getAgreement(Request $request)
    {
        // Validation for all attributes
        $validator = Validator::make($request->all(), [
            'i_id_company' => 'exists:i_id_company',
            'i_id_student' => 'exists:i_id_student',
            'i_id_ukf_employee' => 'exists:i_id_ukf_employee',
            't_url' => 'string|max:255',
            'd_sdate' => 'date_format:Y-m-d',
            'd_edate' => 'date_format:Y-m-d',
            'd_cdate' => 'date_format:Y-m-d',
            's_active' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        // If validation passes, apply filters
        $query = Agreement::query();

        // Apply filters for specified attributes
        foreach ($request->only(['i_id_company', 'i_id_student', 'i_id_ukf_employee', 't_url', 'd_sdate', 'd_edate', 'd_cdate', 's_active']) as $key => $value) {
            if ($request->filled($key)) {
                $query->where($key, $value);
            }
        }

        $agreement = $query->get();

        return response()->json($agreement);
    }
}
