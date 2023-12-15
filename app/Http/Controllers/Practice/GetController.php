<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use App\Services\ResponseService;
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

        $practice = Practice::find($id);
        if($practice){
            return  $this->responseService->createDataResponse($practice);

        } else {
            return $this->responseService->createErrorResponse("Practice with id ".$id. " not found");
        }
    }

    public function getAllPractices(){
        $practice = Practice::all();
        return $this->responseService->createDataResponse($practice);
    }
}
