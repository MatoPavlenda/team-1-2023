<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Services\EditDbRecordService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var ValidatorService
     */
    private $validationService;

    /**
     * @var EditDbRecordService
     */
    private $editDbRecordService;

    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService,
        EditDbRecordService $editDbRecordService
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
        $this->editDbRecordService = $editDbRecordService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:0',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email',
            'password' => 'sometimes|required|string|min:8',
            'company_employee_id' => 'sometimes|nullable|integer|exists:company_employee,id',
            'student_id' => 'sometimes|nullable|integer|exists:student,id',
            'ukf_employee_id' => 'sometimes|nullable|integer|exists:ukf_employee,id',
            'role' => 'sometimes|nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $user = User::find($request->input('id'));

        if (!$user) {
            return $this->responseService->createErrorResponse();
        }

        $user = $this->editDbRecordService->editRecord($user, [
            ['name', $request->input('name')],
            ['email', $request->input('email')],
            ['password', bcrypt($request->input('password'))],
            ['company_employee_id', $request->input('company_employee_id')],
            ['student_id', $request->input('student_id')],
            ['ukf_employee_id', $request->input('ukf_employee_id')],
            ['role', $request->input('role')]
        ]);

        $user->save();

        return $this->responseService->createSuccessfulResponse();

        /*
        $name = $request->input('name');
        $street = $request->input('street');
        $city = $request->input('city');
        $postal_code = $request->input('postal_code');
        $ico = $request->input('ico');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|size:5',
            'ico' => 'required|string|size:8',
        ]);

        //if ($validationResult === true) {
        if (!$validator->fails()) {
            $company = new Company();

            $company->name = $name;
            $company->street = $street;
            $company->city = $city;
            $company->postal_code = $postal_code;
            $company->ico = $ico;

            $company->save();

            return $this->responseService->createSuccessfulResponse();
        } else {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }*/
    }
}