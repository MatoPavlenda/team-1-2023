<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;

class DeleteController extends Controller
{

    public function deleteStudent(int $id)
    {

        $student = Student::find($id);
        if ($student) {


            // Since student uses soft delete it will not delete from table
            $student->delete();
            return response()->json(['message' => 'Student deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Student not found.'], 404);
        }
    }


}
