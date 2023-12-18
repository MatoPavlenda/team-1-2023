<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;

class CreateController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function createUKF_Employee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
        ]);


        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $ukf_employee = UKF_Employee::create($validatedData);

        return $this->responseService->createSuccessfulResponse($ukf_employee);
    }
}

