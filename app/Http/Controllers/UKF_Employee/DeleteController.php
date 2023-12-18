<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;
use App\Services\ResponseService;
use Illuminate\Http\Request;


class DeleteController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function deleteUKF_Employee(Request $request)
    {
        $id = $request->input('id');
        $ukf_employee = UKF_Employee::find($id);
        if ($ukf_employee) {
            $ukf_employee->delete();
            return $this->responseService->createSuccessfulResponse("UKF Employee with id " . $id . " deleted");
        } else {
            return $this->responseService->createErrorResponse("id " .$id." not found");
        }
    }
}
