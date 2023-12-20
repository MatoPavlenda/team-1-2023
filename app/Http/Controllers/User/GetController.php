<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
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
            $user = User::with(['companyEmployee', 'student', 'ukfEmployee'])->find($id);

            if (!$user) {
                return $this->responseService->createErrorResponse();
            }

            return $this->responseService->createDataResponse($user);
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
        $user = User::with(['companyEmployee', 'student', 'ukfEmployee'])->get();
            return $this->responseService->createDataResponse($user);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method3(Request $request)
    {
        $filteredUsers = $this->dynamicFilterService->applyFilters(new User, ['name', 'email', 'password', 'company_employee_id', 'student_id', 'ukf_employee_id', 'role'])->get();


        return $this->responseService->createDataResponse($filteredUsers);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method4(Request $request)
    {
        $filteredUsers = $this->dynamicFilterService->getTotalRowCount(new User);

        return $this->responseService->createDataResponse($filteredUsers);
    }
}