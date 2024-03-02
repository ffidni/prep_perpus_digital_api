<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreateKoleksiPribadiRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Requests\UpdateKoleksiPribadiRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Services\KoleksiPribadiService;
use App\Services\GroupChatService;
use Illuminate\Http\Response;

class KoleksiPribadiController extends Controller
{
    protected $service;

    public function __construct(KoleksiPribadiService $service)
    {
        $this->service = $service;
    }



    /**
     * @lrd:start
     * Mendapatkan semua data Koleksi Pribadi.
     * @lrd:end
     */
    public function index(PaginationRequest $request)
    {
        $data = $this->service->getAllKoleksiPribadis($request);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Koleksi Pribadi', $data->items(), [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ], );
    }

    /**
     * @lrd:start
     * Membuat Koleksi Pribadi baru.
     * @lrd:end
     */
    public function store(CreateKoleksiPribadiRequest $request)
    {
        $data = $request->validated();
        $this->service->createKoleksiPribadi($data);
        return new ApiResponse(Response::HTTP_CREATED, 'Berhasil membuat Koleksi Pribadi', null);
    }

    /**
     * @lrd:start
     * Mendapatkan data Koleksi Pribadi berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /koleksi-pribadi/1
     * @lrd:end
     */
    public function show($id)
    {
        $data = $this->service->getKoleksiPribadiById($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Koleksi Pribadi', $data);
    }

    /**
     * @lrd:start
     * Merubah data Koleksi Pribadi berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /koleksi-pribadi/1
     * @lrd:end
     */
    public function update(UpdateKoleksiPribadiRequest $request, $id)
    {
        $data = $request->validated();
        $this->service->updateKoleksiPribadi($id, $data);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil merubah Koleksi Pribadi', null);
    }

    /**
     * @lrd:start
     * Menghapus data Koleksi Pribadi berdasarkan ID.
     * Pastikan menggunakan path parameter id. Contoh: /koleksi-pribadi/1
     * @lrd:end
     */
    public function destroy($id)
    {
        $this->service->deleteKoleksiPribadi($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil menghapus Koleksi Pribadi', null);
    }
}
