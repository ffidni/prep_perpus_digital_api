<?php
namespace App\Http\Services;

use App\Exceptions\ApiException;
use App\Library\HelperLib;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Config;

class AuthService
{
    public function login(array $credentials)
    {
        $errorMessage = "Email/username atau password salah";
        if (isset($credentials['username'])) {
            if (isset($credentials['email'])) {
                $isEmail = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL);
                if ($isEmail == false) {
                    $user = User::where("username", $credentials['username'])->first();
                    if (!$user) {
                        throw new ApiException(Response::HTTP_BAD_REQUEST, $errorMessage);
                    }
                    $credentials['email'] = $user->email;
                }
            } else {
                $user = User::where("username", $credentials['username'])->first();
                if (!$user) {
                    throw new ApiException(Response::HTTP_BAD_REQUEST, $errorMessage);
                }
                $credentials['email'] = $user->email;
            }
        }
        unset($credentials['username']);
        $token = auth()->attempt($credentials);
        if (!$token) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, $errorMessage);
        }
        $userResponse = isset($user) ? $user : User::where("email", $credentials['email'])->first();
        return $this->responseWithToken($userResponse, $token);
    }


    public function register(array $data, $login = true)
    {
        $user = User::where("email", $data['email'])->exists();
        if ($user) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Email sudah digunakan akun lain");
        }

        $defaultPass = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        if ($login) {
            $userResponse = $this->login(["email" => $data['email'], "password" => $defaultPass]);
            return $userResponse;
        }
        return $user;
    }

    public function refreshToken()
    {
        $user = auth()->user();
        $newToken = auth()->refresh();
        return $this->responseWithToken($user, $newToken);
    }

    public function responseWithToken($user, $token)
    {
        $user->token = str_replace("Bearer ", "", $token);
        $user->token_type = "bearer";
        $user->token_expires_in = auth()->factory()->getTTL() * 60 + time();
        $user->refresh_expires_in = Config::get("jwt.refresh_ttl") * 60;
        return $user;
    }

    public function me($token)
    {
        $user = auth()->user();
        if (!$user) {
            throw new ApiException(Response::HTTP_UNAUTHORIZED, "Invalid token", null);
        }

        return $this->responseWithToken($user, $token);
    }

    public function logout()
    {

        $user = auth()->user();
        if (!$user) {
            throw new ApiException(Response::HTTP_UNAUTHORIZED, "Invalid token", null);
        }
        return auth()->logout();

    }

}
