<?php

namespace App\Http\Controllers;

use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;

class TestController extends Controller
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
        ValidatorService $validationService,
        ResponseService $responseService
    )
    {
        $this->validationService = $validationService;
        $this->responseService = $responseService;
    }

    private $students = [
        'ukf' => [
            'Martin',
            'Peter',
            'Jozef',
            'Ingrida'
        ],
        'spu' => [
            'Martin',
            'Peter',
            'Jozef',
            'Ingrida',
        ],
        'uk' => [
            'Martin',
            'Peter',
            'Jozef',
            'Ingrida',
        ],
        'stu' => [
            'Martin',
            'Peter',
            'Jozef',
            'Ingrida',
        ],
    ];
    public function testMethod(string $name)
    {
        $vysmech = $name . " je strasne smiesny";
        return response()->json($vysmech);
    }

    public function overkillMethod(Request $request)
    {
        $validationResult = $this->validationService->validateVariables([
            [
                'value' => '94911',
                'name' => 'postal',
                'requirements' => [
                    [
                        'type' => 'non_empty'
                    ],
                    [
                        'type' => 'postal'
                    ]
                ]
            ]
        ]);

        if ($validationResult !== true) {
            return $this->validationService->giveValidationResponseError($validationResult);
        }

        return $this->responseService->createSuccessfulResponse();
        /*$pageNum = $request->query('page');
        echo $pageNum;*/
    }

    public function covidMethod(string $name = null)
    {
        if(empty($name)) {
            $response = "Vsetci sme zdravy";
        } else {
            $response = $name . " je chory, ma covid";
        }

        return response()->json($response);

    }

    public function saveStudent(Request $request)
    {
        //$data = $request->json('ukf');
        $data = $request->input('ukf');
        //$data = $request->post('ukf');

        $this->students['ukf'][] = $data;
        return response()->json($this->students);
    }
}
