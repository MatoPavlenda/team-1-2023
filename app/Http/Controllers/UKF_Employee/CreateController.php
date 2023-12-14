<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{

    public function createUKF_Employee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'phone' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:ukf_employee',
            'password' => 'required|string|max:10'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $ukf_employee = UKF_Employee::create($validatedData);

        return response()->json(['message' => 'UKF Employee created successfully.', 'ukf_employee' => $ukf_employee], 201);
    }
}

