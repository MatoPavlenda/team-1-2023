<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Models\StudentReview;

class GetController extends Controller
{
    public function getStudentReviewById(int $studentId, int $ukfEmployeeId)
    {
        $studentReview = StudentReview::where(['student_id' => $studentId, 'ukf_employee_id' => $ukfEmployeeId])->first();

        if ($studentReview) {
            return response()->json($studentReview);
        } else {
            return response()->json("Student Review not found", 404);
        }
    }

    public function getAllStudentReviews()
    {
        $studentReviews = StudentReview::all();
        return response()->json($studentReviews);
    }
}
