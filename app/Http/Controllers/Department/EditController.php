<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;




class EditController extends Controller
{

    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function updateDepartment(Request $request)
    {
        $id = $request->input("id");
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createErrorResponse('Invalid data provided', $validator->errors());
        }

        // Find the department by ID
        $department = Department::find($id);
        if (!$department) {
            return $this->responseService->createErrorResponse('Department not found');
        }

        // Update the department with validated data
        $department->update($validator->validated());

        return $this->responseService->createSuccessfulResponse('Department updated successfully.', ['department' => $department]);
    }
}
