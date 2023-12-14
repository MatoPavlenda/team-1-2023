<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * @var ResponseService
     */
    private $responseService;

    public function __construct(
        ResponseService $responseService
    )
    {
        $this->responseService = $responseService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('your-token-name')->plainTextToken;

            return $this->responseService->createDataResponse(['user' => $user, 'token' => $token]);

            //return response()->json(['message' => 'Login successful', ]);
        }

        return $this->responseService->createUnauthorizedResponse("Invalid credentials");
    }

    public function unauthorized() {
        return $this->responseService->createUnauthorizedResponse("You are unathorized, login on /api/login");
    }

    public function noPermission() {
        return $this->responseService->createNoPermisionResponse("You do not have permission for this action");
    }
}