<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBukuReadRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Services\BukuReadService;
use Illuminate\Http\Response;

class BukuReadController extends Controller
{
    protected $bukuReadService;

    public function __construct(BukuReadService $bukuReadService)
    {
        $this->bukuReadService = $bukuReadService;
    }

    public function index(PaginationRequest $request)
    {
        $data = $this->bukuReadService->getAllBukuReads($request);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Buku Read', $data);
    }

    public function store(CreateBukuReadRequest $request)
    {
        $data = $request->validated();
        $this->bukuReadService->createBukuRead($data);
        return new ApiResponse(Response::HTTP_CREATED, 'Berhasil membuat Buku Read', null);
    }

    public function show($id)
    {
        $data = $this->bukuReadService->getBukuReadById($id);
        return new ApiResponse(Response::HTTP_OK, 'Berhasil mendapatkan semua data Buku Read', $data);
    }

}