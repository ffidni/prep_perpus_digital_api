<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreateUlasanBukuRequest;
use App\Http\Requests\GetUlasanRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Requests\UpdateUlasanBukuRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Services\UlasanBukuService;
use App\Services\GroupChatService;
use Illuminate\Http\Response;

class UlasanBukuController extends Controller
{
    protected $service;

    public function __construct(UlasanBukuService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Mendapatkan semua data Ulasan Buku.
     * @lrd:end
     */
    public function index(PaginationRequest $request, GetUlasanRequest $getUlasanRequest)
    {

        $data = $this->service->getAllUlasanBukus($request, $getUlasanRequest);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Ulasan Buku', $data->items(), [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ], );
    }

    /**
     * @lrd:start
     * Membuat Ulasan Buku baru.
     * @lrd:end
     */
    public function store(CreateUlasanBukuRequest $request)
    {
        $data = $request->validated();
        $this->service->createUlasanBuku($data);
        return new ApiResponse(Response::HTTP_CREATED, 'Berhasil membuat Ulasan Buku', null);
    }

    /**
     * @lrd:start
     * Mendapatkan data Ulasan Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /ulasan-buku/1
     * @lrd:end
     */
    public function show($id)
    {
        $data = $this->service->getUlasanBukuById($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Ulasan Buku', $data);
    }

    /**
     * @lrd:start
     * Merubah data Ulasan Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /ulasan-buku/1
     * @lrd:end
     */
    public function update(UpdateUlasanBukuRequest $request, $id)
    {
        $data = $request->validated();
        $this->service->updateUlasanBuku($id, $data);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil merubah Ulasan Buku', null);
    }

    /**
     * @lrd:start
     * Menghapus data Ulasan Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /ulasan-buku/1
     * @lrd:end
     */
    public function destroy($id)
    {
        $this->service->deleteUlasanBuku($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil menghapus Ulasan Buku', null);
    }
}
