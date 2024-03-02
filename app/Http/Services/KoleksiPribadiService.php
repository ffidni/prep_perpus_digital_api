<?php

namespace App\Http\Services;


use App\Exceptions\ApiException;
use App\Models\GroupChat;
use App\Models\KoleksiPribadiModel;
use Illuminate\Http\Response;

class KoleksiPribadiService
{
    public function createKoleksiPribadi(array $data)
    {
        $user = auth()->user();
        $data['user_id'] = $user->user_id;
        return KoleksiPribadiModel::create($data);
    }

    public function getAllKoleksiPribadis($request)
    {
        $filters = $request->only(["per_page", "page", "search"]);
        $user = auth()->user();
        $query = KoleksiPribadiModel::with("buku")
            ->join('buku', 'koleksi_pribadi.buku_id', '=', 'buku.buku_id')
            ->where('koleksi_pribadi.user_id', $user->user_id);

        if (isset($filters['search'])) {
            $query->where('buku.judul', 'like', '%' . $filters['search'] . '%')
                ->orWhere('buku.penulis', 'like', '%' . $filters['search'] . '%')
                ->orWhere('buku.penerbit', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate($filters['per_page'], ['*'], "Page", $filters['page']);

    }


    public function getKoleksiPribadiById(string $id)
    {
        $user = auth()->user();
        $record = KoleksiPribadiModel::with("buku")->where("koleksi_pribadi_id", $id)->where("user_id", $user->user_id)->first();
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KoleksiPribadi dengan id: $id, tidak ditemukan!", null);
        return $record;
    }

    public function updateKoleksiPribadi(string $id, array $data)
    {
        $user = auth()->user();
        $record = KoleksiPribadiModel::with("buku")->where("koleksi_pribadi_id", $id)->where("user_id", $user->user_id)->first();
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KoleksiPribadi dengan id: $id, tidak ditemukan!", null);
        $record->update($data);
        return $record->fresh();
    }

    public function deleteKoleksiPribadi(string $id)
    {
        $user = auth()->user();
        $record = KoleksiPribadiModel::with("buku")->where("koleksi_pribadi_id", $id)->where("user_id", $user->user_id)->first();

        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "KoleksiPribadi dengan id: $id, tidak ditemukan!", null);

        $record->delete();
        return true;
    }
}
