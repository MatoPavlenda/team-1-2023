<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class GetController extends Controller
{

    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getStudentById(Request $request)
    {
        $id = $request->input('id');
        $student = Student::find($id);
        if($student){
            return $this->responseService->createDataResponse($student);
        } else {
            return $this->responseService->createErrorResponse("Student not found");
        }
    }

    public function getStudentByEmail(Request $request)
    {
        $email = $request->input('email');
        $student = Student::WHERE('email', "=", $email)->first();
        if($student){
            return $this->responseService->createDataResponse($student);
        } else {
            return $this->responseService->createErrorResponse("Student with email " . $email . " not found");
        }
    }

    public function getAllStudents(){
        $students = Student::all();
        return $this->responseService->createDataResponse($students);
    }
}
