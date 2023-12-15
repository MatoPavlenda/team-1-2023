<?php

namespace App\Http\Controllers\PracticeOffer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\PracticeOffer;
use App\Services\EditDbRecordService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use App\Variables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var ValidatorService
     */
    private $validationService;

    /**
     * @var EditDbRecordService
     */
    private $editDbRecordService;

    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService,
        EditDbRecordService $editDbRecordService
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
        $this->editDbRecordService = $editDbRecordService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method(Request $request)
    {
        $id = $request->input('id');
        $title = $request->get('title');
        $description = $request->get('description') ?? ($request->has('description') ? '' : null);
        $start = $request->get('start');
        $end = $request->get('end');
        $student_count = $request->get('student_count');
        $companyEmployeeId = $request->get('company_employee_id');// ?? ($request->has('company_employee_id') ? -1 : null);


        $vars = new Variables();
        $user = auth()->user();

        if ($user->role == $vars->companyEmployee && $companyEmployeeId == null) {
            $companyEmployeeId = $user->companyEmployee->id;

            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|min:0',
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string|max:4294967295',
                'start' => 'sometimes|required|date',
                'end' => 'sometimes|required|date|after:start',
                'student_count' => 'sometimes|required|integer|min:0',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|min:0',
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string|max:4294967295',
                'start' => 'sometimes|required|date',
                'end' => 'sometimes|required|date|after:start',
                'student_count' => 'sometimes|required|integer|min:0',
                'company_employee_id' => 'sometimes|required|integer|min:0|exists:company_employee,id',
            ]);
        }

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $practiceOffer = PracticeOffer::find($id);

        if ($user->role == $vars->companyEmployee) {
            if ($practiceOffer->tutor->company->id != $user->companyEmployee->company->id) {
                return $this->responseService->createNoPermisionResponse("This practice offer does not belong to your company");
            }

            $companyEmployeeDb = CompanyEmployee::find($companyEmployeeId);

            if ($companyEmployeeDb->company->id != $user->companyEmployee->company->id) {
                return $this->responseService->createNoPermisionResponse("You can no add to practice offer tutor (company employee) from other company");
            }
        }


        $practiceOffer = $this->editDbRecordService->editRecord($practiceOffer, [
            ['title', $title],
            ['description', $description],
            ['start', $start],
            ['end', $end],
            ['student_count', $student_count],
            ['tutor_id', $companyEmployeeId]
        ]);

        $practiceOffer->save();

        return $this->responseService->createSuccessfulResponse();
    }
}