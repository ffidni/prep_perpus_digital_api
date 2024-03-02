<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @lrd:start
     * Melakukan proses login pengguna.
     * @lrd:end
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if ($request->has("username")) {
            $data['username'] = $request->username;
        } else if ($request->has("email")) {
            $data['email'] = $request->email;
        }

        $user = $this->authService->login($data);
        return new ApiResponse(Response::HTTP_OK, "Berhasil login", $user);
    }

    /**
     * @LRDparam login string (query)
     * @lrd:start
     * Melakukan proses registrasi pengguna.
     * @lrd:end
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $login = $request->query("login");

        $user = $this->authService->register($data, $login);
        return new ApiResponse(Response::HTTP_OK, "Berhasil register", $user);
    }

    /**
     * @lrd:start
     * Melakukan proses refresh token JWT.
     * @lrd:end
     */
    public function refreshToken() {
        $data = $this->authService->refreshToken(); 
        return new ApiResponse(Response::HTTP_OK, "Berhasil refresh token JWT", $data);
    }

    /**
     * @lrd:start
     * Mengembalikan informasi pengguna yang sedang masuk.
     * @lrd:end
     */
    public function me(Request $request)
    {
        $token = $request->header("Authorization");
        $user = $this->authService->me($token);
        return new ApiResponse(Response::HTTP_OK, "Berhasil mendapatkan user", $user);
    }

    /**
     * @lrd:start
     * Melakukan proses logout pengguna.
     * @lrd:end
     */
    public function logout()
    {
        $this->authService->logout();
        return new ApiResponse(Response::HTTP_OK, "Berhasil logout", null);
    }
}


