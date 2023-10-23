<?php

// src/Controller/YourController.php

namespace App\Controller\Authorization;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ResponseService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    private $jwtManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ResponseService
     */
    private $responseService;

    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        UserRepository $userRepository,
        ResponseService $responseService
    )
    {
        $this->jwtManager = $jwtManager;
        $this->userRepository = $userRepository;
        $this->responseService = $responseService;
    }

    /**
     * @Route("/api/login/user", name="login_user")
     */
    public function yourAction(Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        // Check if the user exists and the password is valid
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user == null) {
            return $this->responseService->createUnauthorizedResponse("Wrong user name");
        }

        dump($user->getRoles());

        if ($passwordHasher->isPasswordValid($user, $password)) {
            $token = $this->jwtManager->create($user);

            dump($this->jwtManager->getUserIdClaim());

            return new JsonResponse([
                'token' => $token,
                'roles' => json_encode($user->getRoles())
            ]);
        } else {
            return $this->responseService->createUnauthorizedResponse("Wrong password");
        }
    }
}
