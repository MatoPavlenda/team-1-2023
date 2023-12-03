<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;
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
        $name = $request->get('name');
        $surname = $request->get('surname');
        $phone = $request->get('phone');
        $email = $request->get('email');
        $password = $request->get('password');

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
                    'value' => $surname,
                    'name' => 'surname',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $phone,
                    'name' => 'phone',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $email,
                    'name' => 'email',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'email'
                        ]
                    ]
                ],
                [
                    'value' => $password,
                    'name' => 'password',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'min_length',
                            'param' => 10
                        ]
                    ]
                ]
            ]
        );

        if ($validationResult === true) {
            $ukf_employee = new UKF_Employee();

            $ukf_employee->name = $name;
            $ukf_employee->surname = $surname;
            $ukf_employee->phone = $phone;
            $ukf_employee->email = $email;
            $ukf_employee->password = Hash::make($password);

            $ukf_employee->save();

            return $this->responseService->createSuccessfulResponse();
        } else {
            return $this->validationService->giveValidationResponseError($validationResult);
        }
    }
}
