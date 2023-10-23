<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    public function createErrorResponse($message = '')
    {
        return new JsonResponse([
            'code' => 400,
            'message' => $message
        ], 400);
    }

    public function createTestResponse() {
        $response = new Response("Test response");
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }
}