<?php

namespace App\Http\Services;


use App\Exceptions\ApiException;
use App\Library\HelperLib;
use App\Models\GroupChat;
use App\Models\KategoriBukuModel;
use Illuminate\Http\Response;

class KategoriBukuService
{
    public function createKategoriBuku(array $data)
    {
        $data['cover'] = HelperLib::uploadFile($data['cover'], "buku/kategori_cover", "cover");
        return KategoriBukuModel::create($data);
    }

    public function getAllKategoriBukus($request)
    {
        $filters = $request->only(["per_page", "page", "search"]);
        $query = KategoriBukuModel::withCount("buku");
        if (isset($filters['search'])) {
            $query->where('nama_kategori', 'like', '%' . $filters['search'] . '%');
        }
        return $query->paginate($filters['per_page'], ['*'], "Page", $filters['page']);

    }

    public function getKategoriBukuById(string $id)
    {
        $record = KategoriBukuModel::withCount("buku")->find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KategoriBuku dengan id: $id, tidak ditemukan!", null);
        return $record;
    }

    public function updateKategoriBuku(string $id, array $data)
    {
        $record = KategoriBukuModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KategoriBuku dengan id: $id, tidak ditemukan!", null);

        if (isset($data['cover'])) {
            $data['cover'] = HelperLib::uploadFile($data['cover'], "buku/kategori_cover", "cover", null, $record->cover);
        }
        $record->update($data);
        return $record->fresh();
    }

    public function deleteKategoriBuku(string $id)
    {
        $record = KategoriBukuModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KategoriBuku dengan id: $id, tidak ditemukan!", null);
        HelperLib::deleteFile($record->cover);
        $record->delete();

        return true;
    }
}