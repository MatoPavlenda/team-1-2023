<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;

class GetController extends Controller
{

    public function getDepartmentById(int $id)
    {
        $department = Department::find($id);
        if($department){
            return response()->json($department);
        } else {
            return response()->json("Department with id " . $id . " not found", 404);
        }
    }

    public function getAllDepartments(){
        $departments = Department::all();
        return response()->json($departments);
    }
}
