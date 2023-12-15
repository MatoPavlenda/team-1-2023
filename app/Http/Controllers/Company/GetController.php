<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GetController extends Controller
{
    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var ValidatorService
     */
    private $validationService;

    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method(Request $request)
    {
        $id = $request->input('id') ?? '';

        if ($id !== '') {
            $company = Company::with('contracts')->find($id);

            if (!$company) {
                return $this->responseService->createErrorResponse();
            }

            return $this->responseService->createDataResponse($company);
        } else {
            $companies = Company::with('contracts')->get();
            return $this->responseService->createDataResponse($companies);
        }
    }
}