<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function verify($user_id, Request $request)
    {
        if(!$request->hasValidSignature()){
            return response()->error("Verification link expired. Kindly try again.");
        }

        try {
            $this->authService->verify($user_id);
        } catch (ModelNotFoundException $exception) {
            return response()->error("Requested user not found.", 404);
        } catch(Throwable $exception) {
            report($exception);

            return response()->error("Error verifying email account.");
        }

        return response()->success([], 'Email account verified successfully.');
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->validateCredentials($request->email);

        if (!$user || !Hash::check($request->password, $user->password)){
            return response()->error("The provided credentials are incorrect.");
        }

        $response = [
          'token' => $user->createToken($request->ip())->plainTextToken,
          'user' => new UserResource($user)
        ];

        return response()->success($response, "Login Successful.");
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->success([], "Your account has been logged out successfully.");
    }
}
