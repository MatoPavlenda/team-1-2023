<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Models\StudentReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;

class EditController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function updateStudentReview(Request $request, int $studentId, int $companyEmployeeId, int $practiceId)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student,id',
            'company_employee_id' => 'required|exists:company_employee,id',
            'practice_id' => 'required|exists:practice,id',
            'rating' => 'required|integer',
            'comment' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $studentReview = StudentReview::where([
            'student_id' => $studentId,
            'company_employee_id' => $companyEmployeeId,
            'practice_id' => $practiceId,
        ])->first();

        if (!$studentReview) {
            return $this->responseService->createErrorResponse("Student Review not found.");
        }

        $studentReview->update($validator->validated());

        return $this->responseService->createSuccessfulResponse("Student Review updated successfully");
    }
}
