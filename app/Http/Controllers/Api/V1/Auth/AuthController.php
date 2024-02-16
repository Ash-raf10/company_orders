<?php

namespace App\Http\Controllers\Api\V1\Auth;


use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private AuthService $authService)
    {
    }

    /**
     * login function
     *
     * @param  LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        [$token, $user] = $this->authService->login($request->validated());

        if (!$token || !$user) {
            return $this->sendResponse(
                false,
                "",
                "Email and password did not match",
                403,
                4001
            );
        }

        $token = $this->authService->generateTokenForUser($user);

        return $this->sendResponse(true, [
            'user' => new UserResource($user),
            'Authorization' => "Bearer $token"
        ], __("Successfully Logged In"));
    }


    /**
     * logout user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();

        return $this->sendResponse(true, "", __("Successfully logged out"), 200, 6000);
    }

    public function me()
    {
        $user = $this->authService->getAuthUser();

        return $this->sendResponse(true, $user, "", 200, 0000);
    }

    /**
     * refresh token
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $token = $this->authService->refreshToken();
        $user = $this->authService->getAuthUser();

        if (!$token || !$user) {
            return $this->sendResponse(false, "", __("Unauthorized"), 403, 6000);
        }

        return $this->sendResponse(true, [
            'user' => $user,
            'Authorization' => "Bearer $token"
        ]);
    }
}
