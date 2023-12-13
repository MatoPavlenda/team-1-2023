<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{

    public function updateStudent(Request $request, $id){

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'surname' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:student,email,' . $id,
            'study_program_id' => 'nullable|exists:study_program,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        // Find the student by ID
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Update the student with validated data
        $student->update($validator->validated());

        return response()->json(['message' => 'Student updated successfully.', 'student' => $student], 200);

    }
}
