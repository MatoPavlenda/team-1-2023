<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
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
            $company = Company::with('contracts')->find($id);

            if (!$company) {
                return $this->responseService->createErrorResponse();
            }

            return $this->responseService->createDataResponse($company);
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
            $companies = Company::with('contracts')->get();
            return $this->responseService->createDataResponse($companies);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method3(Request $request)
    {
        $filteredUsers = $this->dynamicFilterService->applyFilters(new Company, ['name', 'street', 'city', 'postal_code', 'ico'])->get();

        return $this->responseService->createDataResponse($filteredUsers);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method4(Request $request)
    {
        $filteredUsers = $this->dynamicFilterService->getTotalRowCount(new Company);

        return $this->responseService->createDataResponse($filteredUsers);
    }
}