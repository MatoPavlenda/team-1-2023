<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CreateController extends Controller
{

    public function createPractice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'practice_offer_id' => 'required|exists:practice_offers,id',
            'company_employee_id' => 'required|exists:company_employees,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'active' => 'required|boolean',
            'finished' => 'required|boolean',
            'feedback' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $practice = Practice::create($validatedData);

        return response()->json(['message' => 'Practice created successfully.', 'practice' => $practice], 201);
    }
    }
