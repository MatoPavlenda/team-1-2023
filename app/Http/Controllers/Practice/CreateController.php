<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }
    public function createPractice(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student,id',
            'practice_offer_id' => 'required|exists:practice_offer,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'active' => 'required|boolean',
            'finished' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $practice = Practice::create($validatedData);

        return $this->responseService->createSuccessfulResponse($practice);
        }
    }
