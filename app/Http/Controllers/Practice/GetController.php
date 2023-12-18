<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use App\Models\Student;
use App\Services\ResponseService;
use App\Variables;
use Illuminate\Http\Request;

class GetController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getPracticeById(Request $request)
    {
        $id = $request->input('id');
        $vars = new Variables();
        $user = auth()->user();

        if($user->role==$vars->student) {
            $student = $user->student;
            if (!$student) {
                return $this->responseService->createErrorResponse("Student record not found");
            }

            $practice = $student->practices->find($id);
            if ($practice) {
                return $this->responseService->createDataResponse($practice);
            } else {
                return $this->responseService->createUnauthorizedResponse("Unauthorized or practice not found");
            }
        }

        $practice = Practice::find($id);
                if($practice){
            return  $this->responseService->createDataResponse($practice);

        } else {
            return $this->responseService->createErrorResponse("Practice not found");
        }
    }

    public function getAllPractices(){
        $practice = Practice::all();
        return $this->responseService->createDataResponse($practice);
    }
}
