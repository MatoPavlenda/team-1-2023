<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class DeleteController extends Controller
{

    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function deleteDepartment(Request $request)
    {
        $id = $request->input("id");
        $department = Department::find($id);

        if ($department) {
            // Since Department uses soft delete it will not delete from table
            $department->delete();

            return $this->responseService->createSuccessfulResponse('Department deleted successfully.');
        } else {
            return $this->responseService->createErrorResponse('Department not found.');
        }
    }


}
