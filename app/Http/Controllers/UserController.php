<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Services\UserService;
use App\Services\GroupChatService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Mendapatkan semua data User.
     * @lrd:end
     */
    public function index(PaginationRequest $request)
    {
        $data = $this->service->getAllUsers($request);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data User', $data->items(), [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ], );
    }

    /**
     * @lrd:start
     * Membuat User baru.
     * @lrd:end
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $this->service->createUser($data);
        return new ApiResponse(Response::HTTP_CREATED, 'Berhasil membuat User', null);
    }

    /**
     * @lrd:start
     * Mendapatkan data User berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /users/1
     * @lrd:end
     */
    public function show($id)
    {
        $data = $this->service->getUserById($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data User', $data);
    }

    /**
     * @lrd:start
     * Merubah data User berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /users/1
     * @lrd:end
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        $this->service->updateUser($id, $data);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil merubah User', null);
    }

    /**
     * @lrd:start
     * Menghapus data User berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /users/1
     * @lrd:end
     */
    public function destroy($id)
    {
        $this->service->deleteUser($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil menghapus User', null);
    }
}


