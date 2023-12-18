<?php

namespace App\Http\Controllers\CompanyReview;

use App\Http\Controllers\Controller;
use App\Models\CompanyReview;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyReviewController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function createCompanyReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_company' => 'required|exists:company,id',
            'id_practice' => 'required|exists:practice,id',
            'id_student' => 'required|exists:student,id',
            'review_comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        CompanyReview::create($validatedData);

        return $this->responseService->createSuccessfulResponse("Company review created successfully");
    }

    public function getCompanyReview(Request $request)
    {
        $id = $request->input('id');
        $companyReview = CompanyReview::find($id);
        if ($companyReview) {
            return $this->responseService->createDataResponse($companyReview);
        } else {
            return $this->responseService->createErrorResponse("Company review not found");
        }
    }

    public function getAllCompanyReviews()
    {
        $companyReviews = CompanyReview::all();
        return $this->responseService->createDataResponse($companyReviews);
    }

    public function deleteCompanyReview(Request $request)
    {
        $id = $request->input('id');
        $companyReview = CompanyReview::find($id);
        if ($companyReview) {
            $companyReview->delete();
            return $this->responseService->createSuccessfulResponse("Company review deleted successfully");
        } else {
            return $this->responseService->createErrorResponse("Company review not found");
        }
    }

    public function editCompanyReview(Request $request)
    {
        $id = $request->input('id');

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'review_comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $companyReview = CompanyReview::find($id);
        if (!$companyReview) {
            return $this->responseService->createErrorResponse("Company review was not found");
        }

        $companyReview->update($validator->validated());
        return $this->responseService->createSuccessfulResponse("Company review updated sucessfully");
    }
}
