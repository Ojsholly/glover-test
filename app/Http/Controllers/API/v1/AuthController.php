<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

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
}
