<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Update\CreateUpdateRequest;
use App\Http\Resources\Update\UpdateResourceCollection;
use App\Services\Update\UpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class UpdateController extends Controller
{
    private UpdateService $updateService;

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $updates = $this->updateService->findAll(['confirmed_at' => null, 'confirmed_by' => null], request()->query());
        } catch (Throwable $exception) {
            report($exception);

            return response()->error("Error fetching pending updates.");
        }

        return response()->success(new UpdateResourceCollection($updates), "Pending updates fetched successfully.");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUpdateRequest $request
     * @return JsonResponse
     */
    public function store(CreateUpdateRequest $request): JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
