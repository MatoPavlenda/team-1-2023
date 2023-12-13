<?php

namespace App\Http\Controllers\PractiseReport;

use App\Http\Controllers\Controller;
use App\Models\PractiseReport;

class DeleteController extends Controller
{
    public function deletePractiseReport(int $id)
    {
        $practiseReport = PractiseReport::find($id);
        if ($practiseReport) {

            $practiseReport->delete();
            return response()->json(['message' => 'Practise report deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Practise report not found.'], 404);
        }
    }
}
