<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Models\StudentReview;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class GetController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getStudentReviewById(Request $request)
    {
        $studentId = $request->input('student_id');
        $companyEmployeeId = $request->input('company_employee_id');
        $practiceId = $request->input('practice_id');

        $studentReview = StudentReview::where([
            'student_id' => $studentId,
            'company_employee_id' => $companyEmployeeId,
            'practice_id' => $practiceId,
        ])->first();

        if ($studentReview) {
            return $this->responseService->createDataResponse($studentReview);
        } else {
            return $this->responseService->createErrorResponse("Student Review not found");
        }
    }

    public function getAllStudentReviews()
    {
        $studentReviews = StudentReview::all();
        return $this->responseService->createDataResponse($studentReviews);
    }
}
