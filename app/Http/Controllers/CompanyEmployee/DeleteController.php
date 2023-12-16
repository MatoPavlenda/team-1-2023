<?php

namespace App\Http\Controllers\CompanyEmployee;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;
use App\Services\ResponseService;
use Illuminate\Http\Request;


class DeleteController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function deleteCompanyEmployee(Request $request)
    {
        $id = $request->input('id');
        $company_employee = CompanyEmployee::find($id);
        if ($company_employee) {
            // Since company employee uses soft delete it will not delete from table
            $company_employee->delete();
            return $this->responseService->createSuccessfulResponse("Company Employee with id " . $id . " deleted");
        } else {
            return $this->responseService->createErrorResponse("id " .$id." not found");
        }
    }
}
