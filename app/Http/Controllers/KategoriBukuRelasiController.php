<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreateKategoriBukuRelasiRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Requests\UpdateKategoriBukuRelasiRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Services\KategoriBukuRelasiService;
use App\Services\GroupChatService;
use Illuminate\Http\Response;

class KategoriBukuRelasiController extends Controller
{
    protected $service;

    public function __construct(KategoriBukuRelasiService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Mendapatkan semua data Kategori Buku Relasi.
     * @lrd:end
     */
    public function index(PaginationRequest $request)
    {
        $data = $this->service->getAllKategoriBukuRelasis($request);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Kategori Buku Relasi', $data->items(), [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ], );
    }

    /**
     * @lrd:start
     * Membuat Kategori Buku Relasi baru.
     * @lrd:end
     */
    public function store(CreateKategoriBukuRelasiRequest $request)
    {
        $data = $request->validated();
        $this->service->createKategoriBukuRelasi($data);
        return new ApiResponse(Response::HTTP_CREATED, 'Berhasil membuat Kategori Buku Relasi', null);
    }

    /**
     * @lrd:start
     * Mendapatkan data Kategori Buku Relasi berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /kategori-buku-relasi/1
     * @lrd:end
     */
    public function show($id)
    {
        $data = $this->service->getKategoriBukuRelasiById($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Kategori Buku Relasi', $data);
    }

    /**
     * @lrd:start
     * Merubah data Kategori Buku Relasi berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /kategori-buku-relasi/1
     * @lrd:end
     */
    public function update(UpdateKategoriBukuRelasiRequest $request, $id)
    {
        $data = $request->validated();
        $this->service->updateKategoriBukuRelasi($id, $data);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil merubah Kategori Buku Relasi', null);
    }

    /**
     * @lrd:start
     * Menghapus data Kategori Buku Relasi berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /kategori-buku-relasi/1
     * @lrd:end
     */
    public function destroy($id)
    {
        $this->service->deleteKategoriBukuRelasi($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil menghapus Kategori Buku Relasi', null);
    }
}
