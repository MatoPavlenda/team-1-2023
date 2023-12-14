<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Models\StudentReview;

class DeleteController extends Controller
{
    public function deleteStudentReview(int $studentId, int $ukfEmployeeId)
    {
        $studentReview = StudentReview::where(['student_id' => $studentId, 'ukf_employee_id' => $ukfEmployeeId])->first();

        if ($studentReview) {
            $studentReview->delete();
            return response()->json(['message' => 'Student Review deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Student Review not found.'], 404);
        }
    }
}
