<?php

namespace App\Http\Controllers\PracticeOffer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PracticeOffer;
use App\Services\ResponseService;
use App\Services\ValidatorService;
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
        $companyEmployeeId = $request->get('company_employee_id') ?? ''; // TODO - Fix after will work auth

        // TODO - If not specified by header, add actual employee? If employee do not even take header value
        // TODO - Check if employee exist?
        if ($companyEmployeeId == null) {
            $companyEmployeeId = 1;
        }
/*
        $validationResult = $this->validationService->validateVariables(
            [
                [
                    'value' => $title,
                    'name' => 'title',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $start,
                    'name' => 'start',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'datetime'
                        ]
                    ]
                ],
                [
                    'value' => $end,
                    'name' => 'end',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'datetime'
                        ]
                    ]
                ],
                [
                    'value' => $student_count, // TODO - check if negative and zero
                    'name' => 'student_count',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'digits'
                        ]
                    ]
                ]
            ]
        );
*/

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:4294967295',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'student_count' => 'required|integer|min:0',
        ]);


        //if ($validationResult === true) {
        if (!$validator->fails()) {
            $practiceOffer = new PracticeOffer();

            $practiceOffer->tutor_id = $companyEmployeeId;
            $practiceOffer->title = $title;
            $practiceOffer->description = $description;
            $practiceOffer->start = $start;
            $practiceOffer->end = $end;
            $practiceOffer->student_count = $student_count;

            $practiceOffer->save();

            return $this->responseService->createSuccessfulResponse();
        } else {
            return $this->responseService->createErrorResponse($validator->errors());
            //TODO create response according to some standard (roman)
            //return $this->validationService->giveValidationResponseError($validationResult);
        }
    }
}