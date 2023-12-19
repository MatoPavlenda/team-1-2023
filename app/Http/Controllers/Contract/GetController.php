<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySchoolContract;
use App\Services\DynamicFilterService;
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

    /**
     * @var DynamicFilterService
     */
    private $dynamicFilterService;

    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService,
        DynamicFilterService $dynamicFilterService
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
        $this->dynamicFilterService = $dynamicFilterService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method(Request $request)
    {
        $id = $request->input('id') ?? '';

        if ($id !== '') {
            $contract = CompanySchoolContract::with('company')->find($id);

            if (!$contract) {
                return $this->responseService->createErrorResponse();
            }

            return $this->responseService->createDataResponse($contract);
        } else {
            return $this->responseService->createErrorResponse("Id is empty");
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method2(Request $request)
    {
        $contracts = CompanySchoolContract::with('company')->get();
        return $this->responseService->createDataResponse($contracts);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method3(Request $request)
    {
        $filteredUsers = $this->dynamicFilterService->applyFilters(new CompanySchoolContract, ['start', 'end', 'filename', 'company_id'])->get();

        return $this->responseService->createDataResponse($filteredUsers);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method4(Request $request)
    {
        $filteredUsers = $this->dynamicFilterService->getTotalRowCount(new CompanySchoolContract);

        return $this->responseService->createDataResponse($filteredUsers);
    }
}