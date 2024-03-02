<?php

namespace App\Providers;

use App\Http\Services\BukuService;
use App\Http\Services\KategoriBukuRelasiService;
use App\Http\Services\KategoriBukuService;
use App\Http\Services\KoleksiPribadiService;
use App\Http\Services\PeminjamanService;
use App\Http\Services\UlasanBukuService;
use App\Http\Services\UserService;
use App\Http\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BukuService::class, BukuService::class);
        $this->app->bind(KategoriBukuRelasiService::class, KategoriBukuRelasiService::class);
        $this->app->bind(KategoriBukuService::class, KategoriBukuService::class);
        $this->app->bind(KoleksiPribadiService::class, KoleksiPribadiService::class);
        $this->app->bind(PeminjamanService::class, PeminjamanService::class);
        $this->app->bind(UlasanBukuService::class, UlasanBukuService::class);
        $this->app->bind(UserService::class, UserService::class);
        $this->app->bind(AuthService::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
