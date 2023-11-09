<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
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
        $pageNum = $request->query('page');
        echo $pageNum;
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
