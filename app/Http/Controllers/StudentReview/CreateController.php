<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Models\StudentReview;
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

    public function createStudentReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student,id',
            'company_employee_id' => 'required|exists:company_employee,id',
            'practice_id' => 'required|exists:practice,id',
            'rating' => 'required|integer',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $studentReview = StudentReview::create($validatedData);

        return $this->responseService->createSuccessfulResponse($studentReview);
    }
}
