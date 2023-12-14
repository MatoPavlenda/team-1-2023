<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{


    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function createStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student',
            'study_program_id' => 'nullable|exists:study_program,id'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $student = Student::create($validatedData);

        return $this->responseService->createSuccessfulResponse("Student created successfully");
    }
}
