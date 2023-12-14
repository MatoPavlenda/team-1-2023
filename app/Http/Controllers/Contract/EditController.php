<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySchoolContract;
use App\Models\PracticeOffer;
use App\Services\EditDbRecordService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $start = $request->get('start');
        $end = $request->get('end');
        $companyId = $request->get('company_id') ?? ($request->has('company_id') ? -1 : null); // TODO - Fix if comapny exist? - opyat sa halvonika ci treba verifikovat

        $filename = null;

        try {
            // Check if a file was actually uploaded
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $projectDir = base_path();
                $targetDirectory = $projectDir . '/storage/company-school-contract';

                // Ensure the target directory exists
                if (!file_exists($targetDirectory)) {
                    mkdir($targetDirectory, 0777, true);
                }

                // Move the uploaded file to the target location
                $randomName = bin2hex(random_bytes(4));
                $originalFileName = $file->getClientOriginalName();
                $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $targetFileName = $randomName . '.' . $extension;
                $file->move($targetDirectory, $targetFileName);
                $filename = $targetFileName;
            }
        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse('There is problem with file, try insert it again');
        }

        // TODO - All methods verify inputs return error message? Zalezi podla toho ci budu strhavat body

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:0',
            'start' => 'sometimes|required|date',
            'end' => 'sometimes|required|date|after:start',
            'company_id' => 'sometimes|nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            //TODO create response according to some standard (roman)
        }

        $contract = CompanySchoolContract::find($id);

        $contract = $this->editDbRecordService->editRecord($contract, [
            ['start', $start],
            ['end', $end],
            ['company_id', $companyId],
            ['filename', $filename]
        ]);

        $contract->save();

        return $this->responseService->createSuccessfulResponse();
    }
}