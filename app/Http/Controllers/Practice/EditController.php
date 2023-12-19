<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use App\Services\ResponseService;
use App\Variables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function updatePractice(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'id' => 'required',
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
            return $this->responseService->createInvalidDataResponse($validator->errors());
                }

        $id = $request->input('id');
        $practice = Practice::find($id);
        if (!$practice) {
            return $this->responseService->createErrorResponse("Practice with id " .$id . " not found.");
        }

        $practice->update($validator->validated());

        return $this->responseService->createSuccessfulResponse("Practice updated successfully");
    }
}
