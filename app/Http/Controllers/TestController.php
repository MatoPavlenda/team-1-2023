<?php

namespace App\Http\Controllers;

use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

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
            'Marek',
            'Zuzana',
            'Roman',
            'Simon'
        ],
        'spu' => [
            'DanoKis',
            'Nigolas',
            'Ivan',
            'SamoCabaj',
        ],
        'uk' => [
            'Blbecek1',
            'Blbecek2',
            'Blbecek3'
        ],
        'stu' => [
            'MartinM',
            'DruhyTypek',
            'TretiTypek',
            'StvrtyTypek',
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
        $data = $request->input('ukf');

        $this->students['ukf'][] = $data;
        $this->students['spu'][] = $request->input('spu');
        return response()->json($this->students);
    }

    public function mojaMetoda(){
        $vysledok = array_merge($this->students['ukf'], $this->students['spu']);
        return response()->json($vysledok);
    }

    public function postMetoda(Request $request){
        $vysledok = $request->json("ukf");
        return response()->json($vysledok);
    }
}
