<?php

namespace App\Http\Services;

use App\Exceptions\ApiException;
use App\Models\GroupChat;
use App\Models\KategoriBukuRelasiModel;
use Illuminate\Http\Response;

class KategoriBukuRelasiService
{
    public function createKategoriBukuRelasi(array $data)
    {
        return KategoriBukuRelasiModel::create($data);
    }

    public function getAllKategoriBukuRelasis($request)
    {
        $perPage = $request->query("per_page", 10);
        $page = $request->query("page", 1);
        $query = KategoriBukuRelasiModel::query();
        return $query->paginate($perPage, ['*'], "Page", $page);

    }

    public function getKategoriBukuRelasiById(string $id)
    {
        $record = KategoriBukuRelasiModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KategoriBukuRelasi dengan id: $id, tidak ditemukan!", null);
        return $record;
    }

    public function updateKategoriBukuRelasi(string $id, array $data)
    {
        $record = KategoriBukuRelasiModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KategoriBukuRelasi dengan id: $id, tidak ditemukan!", null);
        $record->update($data);
        return $record->fresh();
    }

    public function deleteKategoriBukuRelasi(string $id)
    {
        $record = KategoriBukuRelasiModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KategoriBukuRelasi dengan id: $id, tidak ditemukan!", null);
        $record->delete();

        return true;
    }
}