<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class CreateController extends Controller
{

    public function method(Request $request)
    {
        $newStudent = new Student();
        $newStudent->name = $request->input('name', 'nic');
        $newStudent->surname = $request->input('surname', 'nic');

        $newStudent->save();
        /*     return response()->json([
                 "user_id" => $newStudent->id
             ]); */
    }
}
