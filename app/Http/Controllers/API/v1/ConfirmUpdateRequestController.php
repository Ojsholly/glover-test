<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Services\Update\UpdateService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConfirmUpdateRequestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param UpdateService $updateService
     * @param string $id
     * @return JsonResponse
     */
    public function __invoke(Request $request, UpdateService $updateService, string $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($request, $updateService, $id){
                return $updateService->update(['confirmed_by' => $request->user()->uuid, 'confirmed_at' => now()->toDateTimeString()], $id);
            });
        } catch (ModelNotFoundException | Exception | Throwable $exception) {
            if ($exception instanceof ModelNotFoundException || ($exception instanceof AuthorizationException)) return response()->error($exception->getMessage());

            report($exception);

            return response()->error("Error confirming request update.");
        }

        return response()->success([], "Update request confirmed successfully.");
    }
}
