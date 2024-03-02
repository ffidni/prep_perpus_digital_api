<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBukuRequest;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\GetBukuRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Services\BukuService;
use App\Services\GroupChatService;
use Illuminate\Http\Response;

class BukuController extends Controller
{
    protected $service;

    public function __construct(BukuService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Mendapatkan semua data Buku.
     * @lrd:end
     */
    public function index(PaginationRequest $request, GetBukuRequest $getBukuRequest)
    {

        $data = $this->service->getAllBukus($request, $getBukuRequest);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Buku', $data->items(), [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ], );
    }

    /**
     * @lrd:start
     * Membuat Buku baru.
     * @lrd:end
     */
    public function store(CreateBukuRequest $request)
    {
        $data = $request->validated();
        $this->service->createBuku($data);
        return new ApiResponse(Response::HTTP_CREATED, 'Berhasil membuat Buku', null);
    }

    /**
     * @lrd:start
     * Mendapatkan data Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /buku/1
     * @lrd:end
     */
    public function show($id)
    {
        $data = $this->service->getBukuById($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Buku', $data);
    }

    /**
     * @lrd:start
     * Merubah data Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /buku/1
     * @lrd:end
     */
    public function update(UpdateBukuRequest $request, $id)
    {
        $data = $request->validated();
        $this->service->updateBuku($id, $data);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil merubah Buku', null);
    }

    /**
     * @lrd:start
     * Menghapus data Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /buku/1
     * @lrd:end
     */
    public function destroy($id)
    {
        $this->service->deleteBuku($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil menghapus Buku', null);
    }
}
