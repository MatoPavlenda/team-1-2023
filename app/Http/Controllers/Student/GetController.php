<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\DynamicFilterService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class GetController extends Controller
{

    private $responseService;
    private $dynamicFilterService;

    public function __construct(ResponseService $responseService, DynamicFilterService $dynamicFilterService)
    {
        $this->responseService = $responseService;
        $this->dynamicFilterService = $dynamicFilterService;
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

    public function getStudentByFilter(Request $request){
        $filteredStudents = $this->dynamicFilterService->applyFilters(new Student, ['name', 'surname', 'email'])->get();
        return $this->responseService->createDataResponse($filteredStudents);
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
