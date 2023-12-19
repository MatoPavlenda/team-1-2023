<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use App\Models\Student;
use App\Services\DynamicFilterService;
use App\Services\ResponseService;
use App\Variables;
use Illuminate\Http\Request;

class GetController extends Controller
{
    private $responseService;
    private $dynamicFilterService;

    public function __construct(ResponseService $responseService,DynamicFilterService $dynamicFilterService)
    {
        $this->responseService = $responseService;
        $this->dynamicFilterService = $dynamicFilterService;
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

    public function getPracticeByFilter(Request $request){
        $filteredPractices = $this->dynamicFilterService->applyFilters(new Practice,
            ['student_id',
            'practice_offer_id',
            'title',
            'description',
            'active',
            'finished',])->get();
        return $this->responseService->createDataResponse($filteredPractices);
    }

    public function getAllPractices(){
        $practice = Practice::all();
        return $this->responseService->createDataResponse($practice);
    }
}
