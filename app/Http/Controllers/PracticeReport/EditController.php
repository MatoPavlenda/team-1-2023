<?php

namespace App\Http\Controllers\PracticeReport;

use App\Http\Controllers\Controller;
use App\Models\PracticeReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;

class EditController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function updatePracticeReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'practice_id' => 'sometimes|exists:practice,id',
            'date' => 'sometimes|date',
            'time' => 'sometimes|integer',
            'description' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        // Find the PracticeReport by ID
        $id = $request->input('id');
        $practiceReport = PracticeReport::find($id);

        if (!$practiceReport) {
            return $this->responseService->createErrorResponse("Practice report with id " . $id . " not found.");
        }

        // Update the PracticeReport with validated data
        $practiceReport->update($validator->validated());

        return $this->responseService->createSuccessfulResponse("Practice report updated successfully");
    }
}
