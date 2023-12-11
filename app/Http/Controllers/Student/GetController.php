<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use http\Env\Response;

class GetController extends Controller
{

    public function method(int $id)
    {
        $student = Student::find($id);
        if($student){
            return response()->json($student);
        } else {
            return response()->json("Student with id " . $id . " not found", 404);
        }
    }
}
