<?php

namespace App\Http\Controllers\CompanyEmployee;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;
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

    public function createCompanyEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:company_employee',
            'position' => 'required|string|max:50',
            'company_id' => 'required|exists:company,id'
        ]);


        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $companyEmployee = CompanyEmployee::create($validatedData);

        return $this->responseService->createSuccessfulResponse($companyEmployee);
    }
}

