<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{

    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function updateStudent(Request $request)
    {

        $id = $request->input('id');

        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'name' => 'sometimes|string|max:255',
            'surname' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:student,email,' . $id,
            'study_program_id' => 'nullable|exists:study_program,id'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $student = Student::find($id);
        if (!$student) {
            return $this->responseService->createErrorResponse("Student with id " . $id . " was not found");
        }

        $student->update($validator->validated());
        return $this->responseService->createSuccessfulResponse("Student updated sucessfully");
    }
}
