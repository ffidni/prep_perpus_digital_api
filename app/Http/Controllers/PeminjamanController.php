<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreatePeminjamanRequest;
use App\Http\Requests\GetPeminjamanRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Requests\UpdatePeminjamanRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Services\PeminjamanService;
use App\Services\GroupChatService;
use Illuminate\Http\Response;

class PeminjamanController extends Controller
{
    protected $service;

    public function __construct(PeminjamanService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Mendapatkan semua data Peminjaman (user).
     * @lrd:end
     */

    public function getMyPeminjaman(PaginationRequest $request, GetPeminjamanRequest $request2)
    {
        $data = $this->service->getMyPeminjaman($request, $request2);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Peminjaman-mu', $data->items(), [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ], );
    }

    /**
     * @lrd:start
     * Mendapatkan semua data Peminjaman.
     * @lrd:end
     */
    public function index(PaginationRequest $request, GetPeminjamanRequest $request2)
    {
        $data = $this->service->getAllPeminjamans($request, $request2);

        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Peminjaman', $data->items(), [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ], );
    }

    /**
     * @lrd:start
     * Membuat Peminjaman baru.
     * @lrd:end
     */
    public function store(CreatePeminjamanRequest $request)
    {
        $data = $request->validated();
        $this->service->createPeminjaman($data);
        return new ApiResponse(Response::HTTP_CREATED, 'Berhasil membuat Peminjaman', null);
    }

    /**
     * @lrd:start
     * Mendapatkan data Peminjaman berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /peminjaman/1
     * @lrd:end
     */
    public function show($id)
    {
        $data = $this->service->getPeminjamanById($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Peminjaman', $data);
    }

    /**
     * @lrd:start
     * Accept pengembalian buku (ADMIN).
     * Pastikan menggunakan path parameter id. Contoh: /accept-pengembalian/1
     * @lrd:end
     */
    public function acceptPengembalian($id)
    {
        $data = [
            "status_peminjaman" => "dikembalikan",
        ];
        return $this->service->updatePeminjaman($id, $data);
    }

    public function searchPeminjamanByToken($token)
    {
        $record = $this->service->searchPeminjamanByToken($token);
        return new ApiResponse(Response::HTTP_OK, "Berhasil mendapatkan data peminjaman", $record);
    }

    /**
     * @lrd:start
     * Accept request peminjaman dari user (ADMIN).
     * Pastikan menggunakan path parameter id. Contoh: /accept-peminjaman-request/1
     * @lrd:end
     */
    public function acceptPeminjamanRequest($id)
    {
        $data = [
            "status_peminjaman" => "dipinjam",
        ];
        return $this->service->updatePeminjaman($id, $data);
    }

    /**
     * @lrd:start
     * Merubah data Peminjaman berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /peminjaman/1
     * @lrd:end
     */
    public function update(UpdatePeminjamanRequest $request, $id)
    {
        $data = $request->validated();
        $this->service->updatePeminjaman($id, $data);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil merubah Peminjaman', null);
    }

    /**
     * @lrd:start
     * Menghapus data Peminjaman berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /peminjaman/1
     * @lrd:end
     */
    public function destroy($id)
    {
        $this->service->deletePeminjaman($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil menghapus Peminjaman', null);
    }
}
