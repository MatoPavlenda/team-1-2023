<?php

namespace App\Http\Controllers\CompanyReview;

use App\Http\Controllers\Controller;
use App\Models\CompanyReview;
use App\Models\Practice;
use App\Services\DynamicFilterService;
use App\Services\ResponseService;
use App\Variables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyReviewController extends Controller
{
    private $responseService;
    private $dynamicFilterService;

    public function __construct(ResponseService $responseService, DynamicFilterService $dynamicFilterService)
    {
        $this->responseService = $responseService;
        $this->dynamicFilterService = $dynamicFilterService;
    }

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

        $vars = new Variables();
        $user = auth()->user();

        if ($user->role == $vars->student) {
            $student = $user->student;
            if (!$student) {
                return $this->responseService->createErrorResponse("Student record not found");
            }

            if ($student->id !== $request->input('id_student')) {
                return $this->responseService->createUnauthorizedResponse("You cannot add reviews for other students");
            }

            $practiceId = $request->get('id_practice');
            $hasPractice = $student->practices()->where('id', $practiceId)->exists();
            if (!$hasPractice) {
                return $this->responseService->createUnauthorizedResponse("You cannot add review for practice you have not been to");
            }
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

    public function getCompanyReviewByFilter(Request $request)
    {
        $filteredCompanyReviews = $this->dynamicFilterService->applyFilters(new CompanyReview(),
            ['id_company', 'id_practice', 'id_student', 'rating', 'review_comment'])->get();
        return $this->responseService->createDataResponse($filteredCompanyReviews);
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

        if ($user->role == $vars->student) {
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
