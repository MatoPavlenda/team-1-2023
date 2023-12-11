<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;

class GetController extends Controller
{

    public function getStudentById(int $id)
    {
        $student = Student::find($id);
        if($student){
            return response()->json($student);
        } else {
            return response()->json("Student with id " . $id . " not found", 404);
        }
    }

    public function getStudentByEmail(String $email)
    {
        $student = Student::WHERE('email', "=", $email)->first();
        if($student){
            return response()->json($student);
        } else {
            return response()->json("Student with email " . $email . " not found", 404);
        }
    }

    public function getAllStudents(){
        $students = Student::all();
        return response()->json($students);
    }
}
