<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;


class GetController extends Controller
{

    public function getUKF_EmployeeById(int $id)
    {
        $ukf_employee = UKF_Employee::find($id);
        if ($ukf_employee) {
            return response()->json($ukf_employee);
        } else {
            return response()->json("UKF Employee with id " . $id . " not found", 404);
        }
    }

    public function getUKF_EmployeeByEmail(String $email)
    {
        $ukf_employee = UKF_Employee::WHERE('email', "=", $email)->first();
        if($ukf_employee){
            return response()->json($ukf_employee);
        } else {
            return response()->json("UKF Employee with email " . $email . " not found", 404);
        }
    }

    public function getUKF_EmployeeByFullName(String $name, String $surname)
    {
        $ukf_employee = UKF_Employee::where('name', $name)
            ->where('surname', $surname)
            ->first();

        if ($ukf_employee) {
            return response()->json($ukf_employee);
        } else {
            return response()->json("UKF Employee with name " . $name . " and surname " . $surname . " not found", 404);
        }
    }

    public function getUKF_EmployeeByName(String $name)
    {
        $ukf_employee = UKF_Employee::where('name', $name)->get();

        if ($ukf_employee->isNotEmpty()) {
            return response()->json($ukf_employee);
        } else {
            return response()->json("UKF Employee with name " . $name . " not found", 404);
        }
    }

    public function getUKF_EmployeeBySurname(String $surname)
    {
        $ukf_employee = UKF_Employee::where('surname', $surname)->get();

        if ($ukf_employee->isNotEmpty()) {
            return response()->json($ukf_employee);
        } else {
            return response()->json("UKF Employee with surname " . $surname . " not found", 404);
        }
    }

    public function getAllUKF_Employees(){
        $ukf_employees = UKF_Employee::all();
        return response()->json($ukf_employees);
    }


}
