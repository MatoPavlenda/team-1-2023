<?php

namespace App\Http\Controllers\PracticeReportUpload;

use App\Http\Controllers\Controller;
use App\Models\PracticeReportUpload;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PracticeReportUploadController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function createPracticeReportUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'practice_id' => 'required|exists:practice,id',
            'url' => 'required|url',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        PracticeReportUpload::create($validatedData);

        return $this->responseService->createSuccessfulResponse("Practice report upload created successfully");
    }

    public function getPracticeReportUploadById(Request $request)
    {
        $id = $request->input('id');
        $practiceReportUpload = PracticeReportUpload::find($id);
        if ($practiceReportUpload) {
            return $this->responseService->createDataResponse($practiceReportUpload);
        } else {
            return $this->responseService->createErrorResponse("Practice report upload not found");
        }
    }

    public function getAllPracticeReportUploads()
    {
        $PracticeReportUploads = PracticeReportUpload::all();
        return $this->responseService->createDataResponse($PracticeReportUploads);
    }

    public function getActivePracticeUploads()
    {
        $activePracticeUploads = PracticeReportUpload::where('active', true)->get();
        return $this->responseService->createDataResponse($activePracticeUploads);
    }

    public function deletePracticeReportUpload(Request $request)
    {
        $id = $request->input('id');
        $practiceReportUpload = PracticeReportUpload::find($id);
        if ($practiceReportUpload) {
            $practiceReportUpload->delete();
            return $this->responseService->createSuccessfulResponse("Practice report upload deleted successfully");
        } else {
            return $this->responseService->createErrorResponse("Practice report upload not found");
        }
    }

    public function editPracticeReportUpload(Request $request)
    {
        $id = $request->input('id');

        $validator = Validator::make($request->all(), [
            'practice_id' => 'sometimes|exists:practice,id',
            'url' => 'sometimes|url',
            'active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $practiceReportUpload = PracticeReportUpload::find($id);
        if (!$practiceReportUpload) {
            return $this->responseService->createErrorResponse("Practice report upload was not found");
        }

        $practiceReportUpload->update($validator->validated());
        return $this->responseService->createSuccessfulResponse("Practice report upload updated sucessfully");
    }
}
