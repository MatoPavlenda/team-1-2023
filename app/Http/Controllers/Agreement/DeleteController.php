<?php

namespace App\Http\Controllers\Agreement;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Services\ResponseService;
use Illuminate\Http\Request;


class DeleteController extends Controller
{
    private $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function deleteAgreement(Request $request)
    {
        $id = $request->input('id');
        $agreement = Agreement::find($id);
        if ($agreement) {
            $agreement->delete();
            return $this->responseService->createSuccessfulResponse("Agreement with id " . $id . " deleted");
        } else {
            return $this->responseService->createErrorResponse("id " .$id." not found");
        }
    }
}
