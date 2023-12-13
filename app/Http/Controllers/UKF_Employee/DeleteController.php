<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;


class DeleteController extends Controller
{

    public function deleteUKF_Employee(int $id)
    {
        $ukf_employee = UKF_Employee::find($id);
        if ($ukf_employee) {

            // Since ukf_employee uses soft delete it will not delete from table
            $ukf_employee->delete();
            return response()->json(['message' => 'UKF Employee deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'UKF Employee not found.'], 404);
        }
    }
}
