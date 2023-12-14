<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Models\StudentReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    public function createStudentReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student,id',
            'ukf_employee_id' => 'required|exists:ukf_employee,id',
            'rating' => 'required|integer',
            'comment' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $studentReview = StudentReview::create($validatedData);

        return response()->json(['message' => 'Student Review created successfully.', 'student_review' => $studentReview], 201);
    }
}
