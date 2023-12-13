<?php

namespace App\Http\Controllers\PractiseReport;

use App\Http\Controllers\Controller;
use App\Models\PractiseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    public function updatePractiseReport(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'practise_id' => 'sometimes|exists:practise,id',
            'date' => 'sometimes|date',
            'time' => 'sometimes|integer|max:4',
            'description' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided', 'errors' => $validator->errors()], 422);
        }

        $practiseReport = PractiseReport::find($id);
        if (!$practiseReport) {
            return response()->json(['message' => 'Practise report not found'], 404);
        }

        $practiseReport->update($validator->validated());

        return response()->json(['message' => 'Practise report updated successfully.', 'practise_report' => $practiseReport], 200);
    }
}
