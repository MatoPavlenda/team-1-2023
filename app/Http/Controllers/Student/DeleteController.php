<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteController extends Controller
{

    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function deleteStudent(Request $request)
    {
        $id = $request->input('id');
        $student = Student::find($id);
        if ($student)
        {
            $student->delete();
            return $this->responseService->createSuccessfulResponse("Student with id ".$id." deleted successfully");
        } else {
            return $this->responseService->createErrorResponse("Student not found");
        }
    }
}
