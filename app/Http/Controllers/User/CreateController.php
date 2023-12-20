<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var ValidatorService
     */
    private $validationService;

    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function method(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'company_employee_id' => 'nullable|integer|exists:company_employee,id',
            'student_id' => 'nullable|integer|exists:student,id',
            'ukf_employee_id' => 'nullable|integer|exists:ukf_employee,id',
            'role' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->company_employee_id = $request->input('company_employee_id');
        $user->student_id = $request->input('student_id');
        $user->ukf_employee_id = $request->input('ukf_employee_id');
        $user->role = $request->input('role');

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