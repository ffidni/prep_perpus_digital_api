<?php

namespace App\Http\Services;


use App\Exceptions\ApiException;
use App\Http\Requests\GetPeminjamanRequest;
use App\Http\Requests\PaginationRequest;
use App\Models\GroupChat;
use App\Models\PeminjamanModel;
use Illuminate\Http\Response;

class PeminjamanService
{

    public function generateToken()
    {
        $token = uniqid("peminjaman_", true);
        $isExists = PeminjamanModel::where("token", $token)->exists();
        if (!$isExists) {
            return $token;
        }
        return $this->generateToken();
    }

    public function createPeminjaman(array $data)
    {
        $user = auth()->user();
        $data['user_id'] = $user->user_id;
        $data['token'] = $this->generateToken();
        return PeminjamanModel::create($data);
    }


    public function getMyPeminjaman($paginationRequest, $peminjamanRequest)
    {
        $user = auth()->user();
        $filters = array_merge(
            $paginationRequest->only(
                ["per_page", "page"],
            ),
            $peminjamanRequest->only(["dipinjam", "dikembalikan", "search", "status_peminjaman"])
        );

        $query = PeminjamanModel::with('buku')->with("user")
            ->join("buku", "peminjaman.buku_id", "=", "buku.buku_id")
            ->where("user_id", $user->user_id);

        if (isset($filters['search'])) {
            $query->where('buku.judul', 'like', '%' . $filters['search'] . '%')
                ->orWhere('buku.penulis', 'like', '%' . $filters['search'] . '%')
                ->orWhere('buku.penerbit', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['dipinjam']['from'], $filters['dipinjam']['to'])) {
            $query->whereBetween('tanggal_peminjaman', [$filters['dipinjam']['from'], $filters['dipinjam']['to']]);
        }

        if (isset($filters['dikembalikan']['from'], $filters['dikembalikan']['to'])) {
            $query->whereBetween('tanggal_dikembalikan', [$filters['dikembalikan']['from'], $filters['dikembalikan']['to']]);
        }

        if (isset($filters['status_peminjaman'])) {
            $query->where("status_peminjaman", $filters['status_peminjaman']);
        }

        return $query->paginate($filters['per_page'], ['*'], "Page", $filters['page']);
    }

    public function getAllPeminjamans($paginationRequest, GetPeminjamanRequest $peminjamanRequest)
    {

        $filters = array_merge(
            $paginationRequest->only(
                ["per_page", "page", "search"],
            ),
            $peminjamanRequest->only(["dipinjam", "dikembalikan", "status_peminjaman"])
        );
        $query = PeminjamanModel::with("buku")
            ->join("buku", "peminjaman.buku_id", "=", "buku.buku_id");

        if (isset($filters['search'])) {
            $query->where('buku.judul', 'like', '%' . $filters['search'] . '%')
                ->orWhere('buku.penulis', 'like', '%' . $filters['search'] . '%')
                ->orWhere('buku.penerbit', 'like', '%' . $filters['search'] . '%');
        }
        if (isset($filters['dipinjam'])) {
            $query->whereBetween('tanggal_peminjaman', [$filters['dipinjam']['from'], $filters['dipinjam']['to']]);
        }

        if (isset($filters['dikembalikan'])) {
            $query->whereBetween('tanggal_dikembalikan', [$filters['dikembalikan']['from'], $filters['dikembalikan']['to']]);
        }

        if (isset($filters['status_peminjaman'])) {
            $query->where("status_peminjaman", $filters['status_peminjaman']);
        }


        return $query->paginate($filters['per_page'], ['*'], "Page", $filters['page']);
    }

    public function searchPeminjamanByToken($token)
    {
        $record = PeminjamanModel::where("token", $token)->first();
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "Peminjaman dengan token: $token, tidak ditemukan!", null);
        return $record;
    }


    public function getPeminjamanById(string $id)
    {
        $record = PeminjamanModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "Peminjaman dengan id: $id, tidak ditemukan!", null);
        return $record;
    }


    public function updatePeminjaman(string $id, array $data)
    {
        $record = PeminjamanModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "Peminjaman dengan id: $id, tidak ditemukan!", null);
        $record->update($data);
        return $record->fresh();
    }

    public function deletePeminjaman(string $id)
    {
        $user = auth()->user();
        if ($user->user_type == "admin") {
            $record = PeminjamanModel::find($id);
        } else {
            $record = PeminjamanModel::where("peminjaman_id", $id)->where("user_id", $user->user_id);
        }
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "Peminjaman dengan id: $id, tidak ditemukan!", null);

        $record->delete();
        return true;
    }
}