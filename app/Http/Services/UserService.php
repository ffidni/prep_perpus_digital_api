<?php

namespace App\Http\Services;


use App\Exceptions\ApiException;
use App\Http\Requests\GetUserRequest;
use App\Library\HelperLib;
use App\Models\GroupChat;
use App\Models\User;
use Illuminate\Http\Response;

class UserService
{
    public function createUser(array $data)
    {
        $data['avatar'] = HelperLib::uploadFile($data['avatar'], "user/avatar", "avatar");
        return User::create($data);
    }

    public function getAllUsers($request)
    {
        $filters = $request->only(["per_page", "page", "search"]);
        $query = User::query();

        if (isset($filters['search'])) {
            $query->where("nama", 'like', '%' . $filters['search'] . '%')
                ->orWhere("username", 'like', '%' . $filters['search'] . '%')
                ->orWhere("alamat", 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate($filters['per_page'], ['*'], "Page", $filters['page']);

    }

    public function getUserById(string $id)
    {
        $record = User::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "User dengan id: $id, tidak ditemukan!", null);
        return $record;
    }

    public function updateUser(string $id, array $data)
    {
        $record = User::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "User dengan id: $id, tidak ditemukan!", null);

        if (isset($data['avatar'])) {
            $data['avatar'] = HelperLib::uploadFile($data['avatar'], "user/avatar", "avatar", null, $record->avatar);
        }
        $record->update($data);
        return $record->fresh();
    }

    public function deleteUser(string $id)
    {
        $record = User::find($id);
        if (!$record)
            throw new ApiException(Response::HTTP_NOT_FOUND, "User dengan id: $id, tidak ditemukan!", null);

        HelperLib::deleteFile($record->avatar);
        $record->delete();

        return true;
    }
}