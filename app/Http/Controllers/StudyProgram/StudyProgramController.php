<?php

namespace App\Http\Controllers\StudyProgram;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


//This is only one controller, as it does not as large as others
class StudyProgramController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function createStudyProgram(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'program_code' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        StudyProgram::create($validatedData);

        return $this->responseService->createSuccessfulResponse("Study program created successfully");
    }






}
