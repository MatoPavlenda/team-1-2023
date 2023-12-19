<?php

namespace App\Http\Controllers\PracticeReport;

use App\Http\Controllers\Controller;
use App\Models\PracticeReport;
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

    public function createPracticeReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'practice_id' => 'required|exists:practice,id',
            'date' => 'required|date',
            'time' => 'sometimes|integer',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $practiceReport = PracticeReport::create($validatedData);

        return $this->responseService->createSuccessfulResponse($practiceReport);
    }
}
