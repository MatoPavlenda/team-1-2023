<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySchoolContract;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GetFileController extends Controller
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
        $id = $request->input('id');

        $contract = CompanySchoolContract::find($id);

        if (!$contract) {
            return $this->responseService->createErrorResponse();
        }

        $projectDir = base_path();
        $targetDirectory = $projectDir . '/storage/company-school-contract/';

        return $this->responseService->createFileDownloadResponse($targetDirectory . $contract->filename, $contract->filename);
    }
}