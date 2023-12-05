<?php

namespace App\Http\Controllers\UKF_Employee;

use App\Http\Controllers\Controller;
use App\Models\UKF_Employee;
use App\Services\EditDbRecordService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $id = $request->input('id');
        $name = $request->get('name');
        $surname = $request->get('surname');
        $phone = $request->get('phone');
        $email = $request->get('email');
        $password = $request->get('password');

        $ukf_employee = UKF_Employee::find($id);

        $ukf_employee = $this->editDbRecordService->editRecord($ukf_employee, [
            ['name', $name],
            ['surname', $surname],
            ['phone', $phone],
            ['email', $email],
            ['password', $password]
        ]);

        $ukf_employee->save();

        return $this->responseService->createSuccessfulResponse();
    }
}
