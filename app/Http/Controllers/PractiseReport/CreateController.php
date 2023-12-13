<?php

namespace App\Http\Controllers\PractiseReport;

use App\Http\Controllers\Controller;
use App\Models\PractiseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    public function createPractiseReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'practise_id' => 'required|exists:practise,id',
            'date' => 'required|date',
            'time' => 'sometimes|integer|max:4',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $practiseReport = PractiseReport::create($validatedData);

        return response()->json(['message' => 'Practise report created successfully.', 'practise_report' => $practiseReport], 201);
    }
}
