<?php

// src/Controller/YourController.php

namespace App\Controller;

use App\Service\ResponseService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class YourController extends AbstractController
{
    private $jwtManager;

    /**
     * @var ResponseService
     */
    private $responseService;

    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        ResponseService $responseService
    )
    {
        $this->jwtManager = $jwtManager;
        $this->responseService = $responseService;
    }

    /**
     * @Route("/api/test", name="api_test")
     */
    public function apiTest(Request $request)
    {
        // Your HTML content

        $response = new Response("testResponse");

        // Set the content type to text/html
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }
}
