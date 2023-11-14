<?php

namespace App\Http\Controllers\PracticeOffer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PracticeOffer;
use App\Services\EditDbRecordService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $companyEmployeeId = $request->get('company_employee_id') ?? ($request->has('company_employee_id') ? -1 : null); // TODO - Fix after will work auth

        $practiceOffer = PracticeOffer::find($id);

        // TODO - All methods verify inputs return error message? Zalezi podla toho ci budu strhavat body

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