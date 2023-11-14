<?php

namespace App\Http\Controllers\PracticeOffer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PracticeOffer;
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
            $practiceOffer = PracticeOffer::with('tutor.company')->find($id);

            return $this->responseService->createDataResponse($practiceOffer);
        } else {
            $practiceOffers = PracticeOffer::with('tutor.company')->get();
            return $this->responseService->createDataResponse($practiceOffers);
        }
    }
}