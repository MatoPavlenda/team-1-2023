<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\EditDbRecordService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use App\Variables;
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
        $id = $request->input('id');
        $name = $request->input('name');
        $street = $request->input('street');
        $city = $request->input('city');
        $postal_code = $request->input('postal_code');
        $ico = $request->input('ico');


        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:0',
            'name' => 'sometimes|required|string|max:255',
            'street' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'postal_code' => 'sometimes|required|string|size:5',
            'ico' => 'sometimes|required|string|size:8',
        ]);

        if ($validator->fails()) {
            return $this->responseService->createInvalidDataResponse($validator->errors());
        }

        $company = Company::find($id);

        if (!$company) {
            return $this->responseService->createErrorResponse();
        }

        $vars = new Variables();
        $user = auth()->user();

        if ($user->role == $vars->companyEmployee) {
            $companyIdUser = $user->companyEmployee->company->id;
            if ($companyIdUser != $id) {
                return $this->responseService->createNoPermisionResponse("You you can not edit foreign company");
            }
            if ($user->companyEmployee->admin == 0) {
                return $this->responseService->createNoPermisionResponse("You are not admin of this company");
            }
        }

        $company = $this->editDbRecordService->editRecord($company, [
            ['name', $name],
            ['street', $street],
            ['city', $city],
            ['postal_code', $postal_code],
            ['ico', $ico]
        ]);

        $company->save();

        return $this->responseService->createSuccessfulResponse();
    }
}