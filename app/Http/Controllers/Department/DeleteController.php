<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DeleteController extends Controller
{

    public function deleteDepartment(int $id)
    {

        $department = Department::find($id);
        if ($department) {


            // Since Department uses soft delete it will not delete from table
            $department->delete();
            return response()->json(['message' => 'Department deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Department not found.'], 404);
        }
    }


}
