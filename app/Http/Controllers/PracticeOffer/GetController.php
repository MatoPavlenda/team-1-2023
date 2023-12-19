<?php

namespace App\Http\Controllers\PracticeOffer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PracticeOffer;
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
            $practiceOffer = PracticeOffer::with('tutor.company')->find($id);

            if (!$practiceOffer) {
                return $this->responseService->createErrorResponse();
            }

            return $this->responseService->createDataResponse($practiceOffer);
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
        $practiceOffers = PracticeOffer::with('tutor.company')->get();
        return $this->responseService->createDataResponse($practiceOffers);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method3(Request $request)
    {
        $filteredUsers = $this->dynamicFilterService->applyFilters(new PracticeOffer, ['tutor_id', 'title', 'description', 'start', 'end', 'student_count'])->get();

        return $this->responseService->createDataResponse($filteredUsers);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method4(Request $request)
    {
        $filteredUsers = $this->dynamicFilterService->getTotalRowCount(new PracticeOffer);

        return $this->responseService->createDataResponse($filteredUsers);
    }
}