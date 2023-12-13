<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    public function updatePractice(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'sometimes|exists:student,id',
            'practice_offer_id' => 'sometimes|exists:practice_offer,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'startDate' => 'sometimes|date',
            'endDate' => 'sometimes|date|after_or_equal:startDate',
            'active' => 'sometimes|boolean',
            'finished' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $practice = Practice::find($id);
        if (!$practice) {
            return response()->json(['message' => 'Practice not found'], 404);
        }

        $practice->update($validator->validated());

        return response()->json(['message' => 'Practice created successfully.', 'practice' => $practice], 201);
    }



}
