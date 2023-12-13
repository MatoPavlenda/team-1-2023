<?php

namespace App\Http\Controllers\CompanyEmployee;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;


class DeleteController extends Controller
{

    public function deleteCompanyEmployee(int $id)
    {
        $company_employee = CompanyEmployee::find($id);
        if ($company_employee) {

            // Since company employee uses soft delete it will not delete from table
            $company_employee->delete();
            return response()->json(['message' => 'Company employee deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Company employee not found.'], 404);
        }
    }
}
