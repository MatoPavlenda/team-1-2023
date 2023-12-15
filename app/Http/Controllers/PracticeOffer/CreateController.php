<?php

namespace App\Http\Controllers\PracticeOffer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\PracticeOffer;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use App\Variables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var ValidatorService
     */
    private $validationService;

    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description') ?? '';
        $start = $request->get('start');
        $end = $request->get('end');
        $student_count = $request->get('student_count');
        $companyEmployeeId = $request->get('company_employee_id');

        $vars = new Variables();
        $user = auth()->user();

        if ($user->role == $vars->companyEmployee && $companyEmployeeId == null) {
            $companyEmployeeId = $user->companyEmployee->id;

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:4294967295',
                'start' => 'required|date',
                'end' => 'required|date|after:start',
                'student_count' => 'required|integer|min:0',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:4294967295',
                'start' => 'required|date',
                'end' => 'required|date|after:start',
                'student_count' => 'required|integer|min:0',
                'company_employee_id' => 'required|integer|min:0|exists:company_employee,id',
            ]);
        }

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        if ($user->role == $vars->companyEmployee) {
            $companyEmployeeDb = CompanyEmployee::find($companyEmployeeId);

            if ($companyEmployeeDb->company->id != $user->companyEmployee->company->id) {
                return $this->responseService->createNoPermisionResponse("You can not create practice offer with tutor (company employee) from other company");
            }
        }

        //if ($validationResult === true) {
        //if (!$validator->fails()) {
            $practiceOffer = new PracticeOffer();

            $practiceOffer->tutor_id = $companyEmployeeId;
            $practiceOffer->title = $title;
            $practiceOffer->description = $description;
            $practiceOffer->start = $start;
            $practiceOffer->end = $end;
            $practiceOffer->student_count = $student_count;

            $practiceOffer->save();

            return $this->responseService->createSuccessfulResponse();
//        } else {
//            return $this->responseService->createInvalidDataResponse($validator->errors());
//        }
    }
}