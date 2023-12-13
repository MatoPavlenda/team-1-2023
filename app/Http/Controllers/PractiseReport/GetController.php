<?php

namespace App\Http\Controllers\PractiseReport;

use App\Http\Controllers\Controller;
use App\Models\PractiseReport;

class GetController extends Controller
{
    public function getPractiseReportById(int $id)
    {
        $practiseReport = PractiseReport::find($id);
        if ($practiseReport) {
            return response()->json($practiseReport);
        } else {
            return response()->json("Practise report with id " . $id . " not found", 404);
        }
    }

    public function getAllPractiseReports()
    {
        $practiseReports = PractiseReport::all();
        return response()->json($practiseReports);
    }
}
