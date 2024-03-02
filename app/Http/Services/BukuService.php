<?php

namespace App\Http\Services;

use App\Exceptions\ApiException;
use App\Http\Requests\GetBukuRequest;
use App\Http\Requests\PaginationRequest;
use App\Library\HelperLib;
use App\Models\BukuModel;
use App\Models\GroupChat;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BukuService
{
    public function createBuku(array $data)
    {
        $buku = BukuModel::where("judul", $data['judul'])->where("penulis", $data['penulis'])->first();
        if ($buku)
            throw new ApiException(Response::HTTP_BAD_REQUEST, $data['penulis'] . " sudah memiliki buku yang terunggah dengan judul " . $data['judul'], null);

        $data['cover'] = HelperLib::uploadFile($data['cover'], "buku/buku_cover", "cover");

        $data['ebook_path'] = HelperLib::uploadFile($data['ebook'], "buku/e_books", "book");
        if (!$data['ebook_path'])
            throw new ApiException(Response::HTTP_BAD_REQUEST, $data['penulis'] . " sudah memiliki buku yang terunggah dengan judul " . $data['judul'], null);

        $data['ebook_format'] = $data['ebook']->getClientOriginalExtension();
        $data['ebook_size'] = $data['ebook']->getSize();
        return BukuModel::create($data);
    }

    public function getAllBukus($request, GetBukuRequest $getBukuRequest)
    {
        $filters = array_merge($request->only(["per_page", "page", "search"]), $getBukuRequest->only(["tahun_terbit", "is_premium", "kategori_id"]));
        $user = auth()->user();
        $query = BukuModel::with("daftar_kategori");


        if (isset($filters['search'])) {
            $query->where('judul', 'like', '%' . $filters['search'] . '%')
                ->orWhere('penulis', 'like', '%' . $filters['search'] . '%')
                ->orWhere('penerbit', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['tahun_terbit']['from'], $filters['tahun_terbit']['to'])) {
            $query->whereBetween('tahun_terbit', [$filters['tahun_terbit']['from'], $filters['tahun_terbit']['to']]);
        }

        if (isset($filters['is_premium'])) {
            $query->where('is_premium', $filters['is_premium']);
        }

        if (isset($filters['kategori_id'])) {
            $query->where('kategori_id', $filters['is_premium']);
        }

        return $query->paginate($filters['per_page'], ['*'], "Page", $filters['page']);
    }

    public function getBukuById(string $id)
    {
        $record = BukuModel::with("daftar_kategori")->find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "Buku dengan id: $id, tidak ditemukan!", null);
        $user = auth()->user();
        $user_type = $user->user_type;

        if ($record->is_premium == 1)
            return $record;
    }

    public function updateBuku(string $id, array $data)
    {
        $record = BukuModel::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "Buku dengan id: $id, tidak ditemukan!", null);

        if (isset($data['judul'], $data['penulis'])) {
            $is_other_exist = BukuModel::where("judul", $data['judul'])->where("penulis", $data['penulis'])->first();
            if ($is_other_exist && $is_other_exist->id != $id) {
                throw new ApiException(Response::HTTP_BAD_REQUEST, $data['penulis'] . " sudah memiliki buku yang terunggah dengan judul " . $data['judul'], null);
            }
        }

        if (isset($data['cover'])) {
            $data['cover'] = HelperLib::uploadFile($data['cover'], "buku/buku_cover", "cover", null, $record->cover);
        }
        if (isset($data['ebook'])) {
            $data['ebook_path'] = HelperLib::uploadFile($data['ebook'], "buku/e_books", "book", null, $record->ebook_path);
            if (isset($data['ebook_path'])) {
                $data['ebook_format'] = $data['ebook']->getClientOriginalExtension();
                $data['ebook_size'] = $data['ebook']->getSize() / 1024;
            }
        }
        $record->update($data);
        return $record->fresh();
    }


    public function deleteBuku(string $id)
    {
        $record = BukuModel::find($id);

        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "Buku dengan id: $id, tidak ditemukan!", null);

        HelperLib::deleteFile($record->cover);
        HelperLib::deleteFile($record->ebook_path);
        $record->delete();
        return true;
    }
}