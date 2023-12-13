<?php

namespace App\Http\Controllers\CompanyEmployee;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{

    public function updateCompanyEmployee(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:50',
            'surname' => 'sometimes|string|max:50',
            'email' => 'sometimes|string|email|max:255|unique:company_employee,email,' . $id,
            'position' => 'sometimes|string|max:50',
            'company_id' => 'sometimes|exists:company,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        // Find the CompanyEmployee by ID
        $company_employee = CompanyEmployee::find($id);
        if (!$company_employee) {
            return response()->json(['message' => 'CompanyEmployee not found'], 404);
        }

        // Update the CompanyEmployee with validated data
        $company_employee->update($validator->validated());

        return response()->json(['message' => 'Company employee updated successfully.', 'company_employee' => $company_employee], 200);
    }
}
