<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Models\StudentReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    public function updateStudentReview(Request $request, int $studentId, int $ukfEmployeeId)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|integer',
            'comment' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $studentReview = StudentReview::where(['student_id' => $studentId, 'ukf_employee_id' => $ukfEmployeeId])->first();

        if (!$studentReview) {
            return response()->json(['message' => 'Student Review not found'], 404);
        }

        $studentReview->update($validator->validated());

        return response()->json(['message' => 'Student Review updated successfully.', 'student_review' => $studentReview], 200);
    }
}
