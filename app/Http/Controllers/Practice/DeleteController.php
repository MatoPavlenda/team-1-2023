<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class DeleteController extends Controller
{

    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function deletePractice(Request $request)
    {
        $id = $request->input('id');
        $practice = Practice::find($id);
        if ($practice) {
            $practice->delete();
            return $this->responseService->createSuccessfulResponse("practice with id " . $id . " deleted");
        } else {
            return $this->responseService->createErrorResponse("id " .$id." not found");
        }
    }
}
