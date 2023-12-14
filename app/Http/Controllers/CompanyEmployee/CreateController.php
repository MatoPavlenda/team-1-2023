<?php

namespace App\Http\Controllers\CompanyEmployee;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{

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
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $companyEmployee = CompanyEmployee::create($validatedData);

        return response()->json(['message' => 'Company Employee created successfully.', 'company_employee' => $companyEmployee], 201);
    }
}

