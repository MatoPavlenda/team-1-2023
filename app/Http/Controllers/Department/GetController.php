<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\ResponseService;

class GetController extends Controller
{

    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function getDepartmentById(int $id)
    {
        $department = Department::find($id);
        if ($department) {
            return $this->responseService->createDataResponse($department);
        } else {
            return $this->responseService->createErrorResponse("Department with id $id not found");
        }
    }

    public function getAllDepartments()
    {
        $department = Department::all();
        return $this->responseService->createDataResponse($department);
    }
}
