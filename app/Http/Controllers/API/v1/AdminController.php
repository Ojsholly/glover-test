<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegistrationRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Admin\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AdminController extends Controller
{
    /**
     * @var AdminService
     */
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function store(RegistrationRequest $request): JsonResponse
    {
        $data = $request->except('password') + ['password' => Hash::make($request->password)];

        try {
            $admin = DB::transaction(function () use ($data){
                return $this->adminService->register($data);
            });
        } catch (Throwable $exception) {
            report($exception);

            return response()->error("Error creating administrator account.");
        }

        return response()->success(new UserResource($admin), "Administrator account created successfully.", 201);
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
