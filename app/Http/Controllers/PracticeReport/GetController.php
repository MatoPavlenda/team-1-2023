<?php

namespace App\Http\Controllers\PracticeReport;

use App\Http\Controllers\Controller;
use App\Models\PracticeReport;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class GetController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getPracticeReportById(Request $request)
    {
        $id = $request->input('id');

        $practiceReport = PracticeReport::find($id);
        if ($practiceReport) {
            return $this->responseService->createDataResponse($practiceReport);
        } else {
            return $this->responseService->createErrorResponse("Practice report with id " . $id . " not found");
        }
    }

    public function getAllPracticeReports()
    {
        $practiceReports = PracticeReport::all();
        return $this->responseService->createDataResponse($practiceReports);
    }
}
