<?php

namespace App\Http\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\PaginationRequest;
use App\Models\BukuReadModel;
use Illuminate\Http\Response;

class BukuReadService
{
    public function createBukuRead(array $data)
    {
        $user = auth()->user();
        $data['user_id'] = $user->user_id;
        return BukuReadModel::create($data);
    }

    public function getAllBukuReads(PaginationRequest $paginationRequest)
    {
        $user = auth()->user();
        $filters = $paginationRequest->only(["per_page", "page"]);
        $query = BukuReadModel::with("buku")->where("user_id", $user->user_id);
        return $query->paginate($filters['per_page'], ['*'], "Page", $filters['page']);

    }

    public function getBukuReadById(string $id)
    {
        $user = auth()->user();
        $record = BukuReadModel::with("buku")->where("buku_read_id", $id)->where("user_id", $user->user_id)->first();
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "BukuRead dengan id: $id, tidak ditemukan!", null);

        return $record;
    }
}