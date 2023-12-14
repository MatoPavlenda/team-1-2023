<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySchoolContract;
use App\Models\PracticeOffer;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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

        $start = $request->get('start');
        $end = $request->get('end');
        $company_id = $request->get('company_id') ?? ''; // TODO - Fix if comapny exist? - opyat sa halvonika ci treba verifikovat
/*
        $validationResult = $this->validationService->validateVariables(
            [
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
                    'value' => $company_id,
                    'name' => 'company_id',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'digit'
                        ]
                    ]
                ]
            ]
        );

        if ($validationResult !== true) {
            return $this->validationService->giveValidationResponseError($validationResult);
        }
*/
        try {
            // Check if a file was actually uploaded
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $projectDir = base_path();
                $targetDirectory = $projectDir . '/storage/company-school-contract';

                // Ensure the target directory exists
                if (!file_exists($targetDirectory)) {
                    mkdir($targetDirectory, 0777, true);
                }

                // Move the uploaded file to the target location
                $randomName = bin2hex(random_bytes(4));
                $originalFileName = $file->getClientOriginalName();
                $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $targetFileName = $randomName . '.' . $extension;
                $file->move($targetDirectory, $targetFileName);
            } else {
                return $this->responseService->createErrorResponse('File not uploaded');
            }
        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse('There is problem with file, try insert it again');
        }

        $validator = Validator::make($request->all(), [
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'company_id' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            //TODO create response according to some standard (roman)
        }


        $companySchoolContract = new CompanySchoolContract();

        $companySchoolContract->start = $start;
        $companySchoolContract->end = $end;
        $companySchoolContract->filename = $targetFileName;
        $companySchoolContract->company_id = $company_id;

        $companySchoolContract->save();

        return $this->responseService->createSuccessfulResponse();
    }
}
