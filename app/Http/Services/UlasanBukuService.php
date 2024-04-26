<?php

namespace App\Http\Services;


use App\Exceptions\ApiException;
use App\Http\Requests\GetUlasanRequest;
use App\Models\GroupChat;
use App\Models\UlasanBukuModel;
use Illuminate\Http\Response;

class UlasanBukuService
{
    public function createUlasanBuku(array $data)
    {
        $user = auth()->user();
        $isExists = UlasanBukuModel::where("user_id", $user->user_id)->where("buku_id", $data['buku_id'])->exists();
        if ($isExists)
            throw new ApiException(Response::HTTP_NOT_FOUND, "Kamu sudah menilai buku ini", null);

        $data['user_id'] = $user->user_id;

        return UlasanBukuModel::create($data);
    }

    public function getAllUlasanBukus($request, GetUlasanRequest $getUlasanRequest)
    {
        $user = auth()->user();
        $filters = array_merge($request->only(["search", "per_page", "page"]), $getUlasanRequest->only(["rating"]));
        $query = UlasanBukuModel::with("buku")
            ->join('buku', 'ulasan_buku.buku_id', '=', 'buku.buku_id')
            ->where('ulasan_buku.user_id', $user->user_id);

        if (isset($filters['search'])) {
            $query->where('buku.judul', 'like', '%' . $filters['search'] . '%')
                ->orWhere('buku.penulis', 'like', '%' . $filters['search'] . '%')
                ->orWhere('buku.penerbit', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['rating'])) {
            $query->where("rating", $filters['rating']);
        }
        return $query->paginate($filters['per_page'], ['*'], "Page", $filters['page']);

    }

    public function getUlasanBukuById(string $id)
    {
        $record = UlasanBukuModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "UlasanBuku dengan id: $id, tidak ditemukan!", null);
        return $record;
    }

    public function updateUlasanBuku(string $id, array $data)
    {
        $user = auth()->user();
        $record = UlasanBukuModel::where("ulasan_buku_id", $id)->where("user_id", $user->user_id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "UlasanBuku dengan id: $id, tidak ditemukan!", null);

        $record->update($data);
        return $record->fresh();
    }

    public function deleteUlasanBuku(string $id)
    {
        $user = auth()->user();
        $record = UlasanBukuModel::where("ulasan_buku_id", $id)->where("user_id", $user->user_id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "UlasanBuku dengan id: $id, tidak ditemukan!", null);

        $record->delete();
        return true;
    }
}