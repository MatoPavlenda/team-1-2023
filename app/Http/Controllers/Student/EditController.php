<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
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

    public function updateStudent(Request $request)
    {

        $id = $request->input('id');

        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'name' => 'sometimes|string|max:255',
            'surname' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:student,email,' . $id,
            'study_program_id' => 'nullable|exists:study_program,id'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $student = Student::find($id);
        if (!$student) {
            return $this->responseService->createErrorResponse("Student with id " . $id . " was not found");
        }

        $student->update($validator->validated());
        return $this->responseService->createSuccessfulResponse("Student updated sucessfully");
    }

    public function attachStudentToStudyProgram(Request $request){

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student,id',
            'study_program_id' => 'required|exists:study_program,id',
            'attach'=>'required|boolean'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }
            $studentId = $request->input('student_id');
            $studyProgramId = $request->input('study_program_id');
            $attach = $request->input('attach');

            $student = Student::find($studentId);
            if (!$student) {
                return $this->responseService->createErrorResponse("Student not found");
            }

            if($attach){
                $student->studyPrograms()->attach($studyProgramId);
                return $this->responseService->createSuccessfulResponse("Student successfully attached");
            }else{
                $student->studyPrograms()->detach($studyProgramId);
                return $this->responseService->createSuccessfulResponse("Student successfully detached");
            }
    }

    public function attachStudentToPracticeOffer(Request $request){
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student,id',
            'practice_offer_id' => 'required|exists:practice_offer,id',
            'attach'=>'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $vars = new Variables();
        $user = auth()->user();
        $studentId = $request->input('student_id');
        $practiceOfferId = $request->input('practice_offer_id');

        if($user->role==$vars->student) {
            $studentUser = $user->student;
            if (!$studentUser) {
                return $this->responseService->createErrorResponse("Student record not found");
            }

            if($studentUser->id !== $studentId){
                return $this->responseService->createUnauthorizedResponse("You cannot apply to practice offer with someone else than you");
            }
        }

        $attach = $request->input('attach');

        $student = Student::find($studentId);
        if (!$student) {
            return $this->responseService->createErrorResponse("Student record not found");
        }

        if($attach){
            $student->practiceOffers()->attach($practiceOfferId);
            return $this->responseService->createSuccessfulResponse("Student successfully attached");
        }else{
            $student->practiceOffers()->detach($practiceOfferId);
            return $this->responseService->createSuccessfulResponse("Student successfully detached");
        }
    }
}
