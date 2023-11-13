<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $name = $request->input('name');
        $street = $request->input('street');
        $city = $request->input('city');
        $postal_code = $request->input('postal_code');
        $ico = $request->input('ico');

        $validationResult = $this->validationService->validateVariables(
            [
                [
                    'value' => $name,
                    'name' => 'name',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $street,
                    'name' => 'street',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $city,
                    'name' => 'city',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $postal_code,
                    'name' => 'postal_code',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'postal'
                        ]
                    ]
                ],
                [
                    'value' => $ico,
                    'name' => 'ico',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'digits'
                        ],
                        [
                            'type' => 'length',
                            'value' => '8'
                        ]
                    ]
                ]
            ]
        );

        if ($validationResult === true) {
            $company = new Company();

            $company->name = $name;
            $company->street = $street;
            $company->city = $city;
            $company->postal_code = $postal_code;
            $company->ico = $ico;

            $company->save();

            return $this->responseService->createSuccessfulResponse();
        } else {
            return $this->validationService->giveValidationResponseError($validationResult);
        }
    }
}