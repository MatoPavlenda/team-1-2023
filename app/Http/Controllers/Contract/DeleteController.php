<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySchoolContract;
use App\Services\EditDbRecordService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeleteController extends Controller
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

        $contract = CompanySchoolContract::find($id);

        if ($contract) {
            $contract->delete();

            return $this->responseService->createSuccessfulResponse();
        } else {
            return $this->responseService->createErrorResponse();
        }
    }
}