<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{

    public function createDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $department = Department::create($validatedData);

        return response()->json(['message' => 'Department created successfully.', 'department' => $department], 201);
    }
}
