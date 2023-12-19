<?php

namespace App\Http\Controllers\CompanyReview;

use App\Http\Controllers\Controller;
use App\Models\CompanyReview;
use App\Services\ResponseService;
use App\Variables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyReviewController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    //TODO doplnit aby mohli studenti len za seba pridavat
    public function createCompanyReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_company' => 'required|exists:company,id',
            'id_practice' => 'required|exists:practice,id',
            'id_student' => 'required|exists:student,id',
            'review_comment' => 'sometimes|nullable|string',
            'rating' => 'required|integer|min:1|max:10',
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

        $vars = new Variables();
        $user = auth()->user();

        if($user->role==$vars->student) {
            $student = $user->student;
            if (!$student) {
                return $this->responseService->createErrorResponse("Student record not found");
            }

            $companyReview = $student->companyReviews->find($id);
            if (!$companyReview) {
                return $this->responseService->createUnauthorizedResponse("Unauthorized to change your review thats not yours");
            }
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_student' => 'required|exists:student,id',
            'review_comment' => 'sometimes|string',
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
