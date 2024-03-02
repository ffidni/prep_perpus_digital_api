<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreateKategoriBukuRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Requests\UpdateKategoriBukuRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Services\KategoriBukuService;
use App\Services\GroupChatService;
use Illuminate\Http\Response;

class KategoriBukuController extends Controller
{
    protected $service;

    public function __construct(KategoriBukuService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Mendapatkan semua data Kategori Buku.
     * @lrd:end
     */
    public function index(PaginationRequest $request)
    {
        $data = $this->service->getAllKategoriBukus($request);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Kategori Buku', $data->items(), [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ], );
    }

    /**
     * @lrd:start
     * Membuat Kategori Buku baru.
     * @lrd:end
     */
    public function store(CreateKategoriBukuRequest $request)
    {
        $data = $request->validated();
        $this->service->createKategoriBuku($data);
        return new ApiResponse(Response::HTTP_CREATED, 'Berhasil membuat Kategori Buku', null);
    }

    /**
     * @lrd:start
     * Mendapatkan data Kategori Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /kategori-buku/1
     * @lrd:end
     */
    public function show($id)
    {
        $data = $this->service->getKategoriBukuById($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Kategori Buku', $data);
    }

    /**
     * @lrd:start
     * Merubah data Kategori Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /kategori-buku/1
     * @lrd:end
     */
    public function update(UpdateKategoriBukuRequest $request, $id)
    {
        $data = $request->validated();
        $this->service->updateKategoriBuku($id, $data);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil merubah Kategori Buku', null);
    }

    /**
     * @lrd:start
     * Menghapus data Kategori Buku berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /kategori-buku/1
     * @lrd:end
     */
    public function destroy($id)
    {
        $this->service->deleteKategoriBuku($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil menghapus Kategori Buku', null);
    }
}
