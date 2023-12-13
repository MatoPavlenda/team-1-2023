<?php
namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\File;

class ResponseService
{
    public function createUnauthorizedResponse($message = 'Unauthorized')
    {
        return new JsonResponse([
            'code' => 401,
            'message' => $message
        ], 401);
    }

    public function createSuccessfulResponse($message = '')
    {
        return new JsonResponse([
            'code' => 200,
            'message' => $message
        ], 200);
    }

    public function createDataResponse($jsonData)
    {
        return new JsonResponse([
            'code' => 200,
            'data' => $jsonData
        ], 200);
    }

    public function createFileDownloadResponse($filePath, $filename) {
        $contentType = File::mimeType($filePath);

        $headers = [
            'Content-Type' => $contentType, // Adjust the content type based on your file type
        ];

        return response()->download($filePath, $filename, $headers);
    }

    public function createErrorResponse($message = '')
    {
        return new JsonResponse([
            'code' => 400,
            'message' => $message
        ], 400);
    }

    public function createTestResponse()
    {
        $response = new Response("Test response");
        $response->header('Content-Type', 'text/html');

        return $response;
    }
}