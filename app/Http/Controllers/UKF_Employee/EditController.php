<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{

    public function updateUKF_Employee(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:50',
            'surname' => 'sometimes|string|max:50',
            'phone' => 'sometimes|string|max:10',
            'email' => 'sometimes|string|email|max:255|unique:ukf_employee,email' .$id,
            'password' => 'sometimes|string|max:10'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        // Find the student by ID
        $ukf_employee = UKF_Employee::find($id);
        if (!$ukf_employee) {
            return response()->json(['message' => 'UKF Employee not found'], 404);
        }

        // Hash the password
        $hashedPassword = Hash::make($validator->validated()['password']);

        // Update the UKF_Employee with validated data and hashed password
        $ukf_employee->update(array_merge($validator->validated(), ['password' => $hashedPassword]));

        return response()->json(['message' => 'UKF Employee updated successfully.', 'ukf_employee' => $ukf_employee], 200);




    }
}
