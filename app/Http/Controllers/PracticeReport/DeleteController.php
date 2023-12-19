<?php

namespace App\Http\Controllers\PracticeReport;

use App\Http\Controllers\Controller;
use App\Models\PracticeReport;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function deletePracticeReport(Request $request)
    {
        $id = $request->input('id');
        $practiceReport = PracticeReport::find($id);
        if ($practiceReport) {
            $practiceReport->delete();
            return $this->responseService->createSuccessfulResponse("Practice report with id " . $id . " deleted");
        } else {
            return $this->responseService->createErrorResponse("Practice report with id " . $id . " not found");
        }
    }
}
