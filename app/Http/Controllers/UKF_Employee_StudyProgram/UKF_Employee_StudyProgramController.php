<?php


namespace App\Http\Controllers\UKF_Employee_StudyProgram;
use App\Http\Controllers\Controller;
use App\Models\UKF_Employee_StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ResponseService;
use App\Models\UKF_Employee;
use App\Models\StudyProgram;

class UKF_Employee_StudyProgramController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function createUKF_Employee_StudyProgram(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ukf_employee_id' => 'required|exists:ukf_employee,id',
            'study_program_id' => 'required|exists:study_program,id',
            's_date' => 'required|date',
            'e_date' => 'required|date|after:s_date',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $validatedData = $validator->validated();
        $ukf_employee_study_program = UKF_Employee_StudyProgram::create($validatedData);

        return $this->responseService->createSuccessfulResponse($ukf_employee_study_program);
    }

    public function updateUKF_Employee_StudyProgram(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ukf_employee_id' => 'sometimes|exists:ukf_employee,id',
            'study_program_id' => 'sometimes|exists:study_program,id',
            's_date' => 'sometimes|date_format:Y-m-d',
            'e_date' => 'sometimes|date_format:Y-m-d',
            'active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        // Find the UKF_Employee_StudyProgram by ID
        $id = $request->input('id');
        $ukf_employee_study_program = UKF_Employee_StudyProgram::find($id);
        if (!$ukf_employee_study_program) {
            return $this->responseService->createErrorResponse("UKF_Employee_StudyProgram with id " . $id . " not found.");
        }

        // Update the UKF_Employee_StudyProgram with validated data
        $ukf_employee_study_program->update($validator->validated());

        return $this->responseService->createSuccessfulResponse("UKF_Employee_StudyProgram updated successfully");
    }

    public function deleteUKF_Employee_StudyProgram(Request $request)
    {
        $id = $request->input('id');
        $ukf_employee_study_program = UKF_Employee_StudyProgram::find($id);
        if ($ukf_employee_study_program) {
            $ukf_employee_study_program->delete();
            return $this->responseService->createSuccessfulResponse("UKF_Employee_StudyProgram with id " . $id . " deleted");
        } else {
            return $this->responseService->createErrorResponse("UKF_Employee_StudyProgram with id " . $id . " not found");
        }
    }

    public function getUKF_Employee_StudyProgramById(Request $request)
    {
        $id = $request->input('id');

        $ukf_employee_study_program = UKF_Employee_StudyProgram::find($id);
        if ($ukf_employee_study_program) {
            return $this->responseService->createDataResponse($ukf_employee_study_program);
        } else {
            return $this->responseService->createErrorResponse("UKF_Employee_StudyProgram with id " . $id . " not found");
        }
    }

    public function getUKF_Employee_StudyProgramByFilter(Request $request)
    {
        $query = UKF_Employee_StudyProgram::query();

        // Filter by active
        if ($request->has('active')) {
            $active = $request->input('active');
            $query->where('active', '=', $active);
        }

        // Filter by s_date
        if ($request->has('s_date')) {
            $s_date = $request->input('s_date');
            $query->where('s_date', '=', $s_date);
        }

        // Filter by e_date
        if ($request->has('e_date')) {
            $e_date = $request->input('e_date');
            $query->where('e_date', '=', $e_date);
        }


        // Filter by ukf_employee name
        if ($request->has('UKF_employee_name')) {
            $UKF_employeeName = $request->input('UKF_employee_name');

            // Find company ID based on name
            $UKF_employeeId = UKF_Employee::where('name', $$UKF_employeeName)->value('id');

            if ($UKF_employeeId) {
                $query->where('ukf_employee_id', $UKF_employeeId);
            } else {
                return $this->responseService->createErrorResponse("UKF employee with name " . $UKF_employeeName . " not found");
            }
        }
        // Filter by study_program
        if ($request->has('study_program_name')) {
            $study_program_name = $request->input('study_program_name');

            // Find department ID based on title
            $study_program_name = StudyProgram::where('name', $study_program_name)->value('id');

            if ($study_program_name) {
                $query->where('study_program_id', $study_program_name);
            } else {
                return $this->responseService->createErrorResponse("StudyProgram with name " . $study_program_name . " not found");
            }
        }

        $ukfEmployeeStudyProgram= $query->get();

        if ($ukfEmployeeStudyProgram->isNotEmpty()) {
            return $this->responseService->createDataResponse($ukfEmployeeStudyProgram);
        } else {
            return $this->responseService->createErrorResponse("No UKF_Employee_StudyProgram found with the specified filters");
        }
    }


    public function getAllUKF_Employee_StudyPrograms()
    {
        $ukf_employee_study_programs = UKF_Employee_StudyProgram::all();
        return $this->responseService->createDataResponse($ukf_employee_study_programs);
    }






}
