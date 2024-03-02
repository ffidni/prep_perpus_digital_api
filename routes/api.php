<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\KategoriBukuRelasiController;
use App\Http\Controllers\KoleksiPribadiController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UlasanBukuController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(["middleware" => "api", "prefix" => "v1"], function () {
    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::get('buku', [BukuController::class, 'index']);
    Route::get('buku/{id}', [BukuController::class, 'show'])->where('id', '[0-9]+');
    Route::get('kategori-buku', [KategoriBukuController::class, 'index']);
    Route::get('kategori-buku/{id}', [KategoriBukuController::class, 'show'])->where('id', '[0-9]+');
    Route::post('test', [TestController::class, 'postTest'])->where('id', '[0-9]+');
    Route::get('test', [TestController::class, 'getTest'])->where('id', '[0-9]+');


    Route::group(["middleware" => "jwt.verify"], function () {
        Route::post("/refresh-token", [AuthController::class, "refreshToken"]);
        Route::get("/me", [AuthController::class, "me"]);

        Route::get('kategori-buku-relasi', [KategoriBukuRelasiController::class, 'index']);
        Route::get('kategori-buku-relasi/{id}', [KategoriBukuRelasiController::class, 'show'])->where('id', '[0-9]+');

        // Buku routes
        Route::group(["middleware" => "admin.librarian"], function () {
            Route::get('all-peminjaman', [PeminjamanController::class, 'index']);
            Route::put('update-peminjaman/{id}', [PeminjamanController::class, 'update'])->where('id', '[0-9]+');
            Route::put('accept-peminjaman-request/{id}', [PeminjamanController::class, 'acceptPeminjamanRequest'])->where('id', '[0-9]+');
            Route::put('accept-pengembalian/{id}', [PeminjamanController::class, 'acceptPengembalian'])->where('id', '[0-9]+');

            Route::post('create-buku', [BukuController::class, 'store']);
            Route::post('update-buku/{id}', [BukuController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('delete-buku/{id}', [BukuController::class, 'destroy'])->where('id', '[0-9]+');

            // Kategori Buku routes
            Route::post('create-kategori-buku', [KategoriBukuController::class, 'store']);
            Route::post('update-kategori-buku/{id}', [KategoriBukuController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('delete-kategori-buku/{id}', [KategoriBukuController::class, 'destroy'])->where('id', '[0-9]+');

            // Kategori Buku Relasi routes
            Route::post('create-kategori-buku-relasi', [KategoriBukuRelasiController::class, 'store']);
            Route::put('update-kategori-buku-relasi/{id}', [KategoriBukuRelasiController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('delete-kategori-buku-relasi/{id}', [KategoriBukuRelasiController::class, 'destroy'])->where('id', '[0-9]+');
        });

        Route::group(["middleware" => "member"], function () {
            // Koleksi Prbadi routes
            Route::get('koleksi-pribadi', [KoleksiPribadiController::class, 'index']);
            Route::post('add-to-collection', [KoleksiPribadiController::class, 'store']);
            Route::put('update-koleksi-pribadi/{id}', [KoleksiPribadiController::class, 'update'])->where('id', '[0-9]+');
            Route::get('koleksi-pribadi/{id}', [KoleksiPribadiController::class, 'show'])->where('id', '[0-9]+');
            Route::delete('delete-from-collection/{id}', [KoleksiPribadiController::class, 'destroy'])->where('id', '[0-9]+');

            // Peminjaman routes
            Route::get('my-peminjaman', [PeminjamanController::class, 'getMyPeminjaman']);
            Route::post('request-peminjaman', [PeminjamanController::class, 'store']);
            Route::get('peminjaman/{id}', [PeminjamanController::class, 'show'])->where('id', '[0-9]+');
            Route::delete('cancel-request/{id}', [PeminjamanController::class, 'destroy'])->where('id', '[0-9]+');

            // Ulasan Buku routes
            Route::get('ulasan-buku', [UlasanBukuController::class, 'index']);
            Route::post('create-ulasan-buku', [UlasanBukuController::class, 'store']);
            Route::get('ulasan-buku/{id}', [UlasanBukuController::class, 'show'])->where('id', '[0-9]+');
            Route::put('update-ulasan-buku/{id}', [UlasanBukuController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('delete-ulasan-buku/{id}', [UlasanBukuController::class, 'destroy'])->where('id', '[0-9]+');
        });

        Route::group(["middleware" => "admin"], function () {
            // User routes
            Route::get('all-peminjaman', [PeminjamanController::class, 'index']);
            Route::put('update-peminjaman/{id}', [PeminjamanController::class, 'update'])->where('id', '[0-9]+');
            Route::put('accept-peminjaman-request/{id}', [PeminjamanController::class, 'acceptPeminjamanRequest'])->where('id', '[0-9]+');
            Route::put('accept-pengembalian/{id}', [PeminjamanController::class, 'acceptPengembalian'])->where('id', '[0-9]+');
            Route::get('users', [UserController::class, 'index']);
            Route::post('create-user', [UserController::class, 'store']);
            Route::get('users/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');
            Route::post('update-user/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('delete-user/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');
        });
    });

});
