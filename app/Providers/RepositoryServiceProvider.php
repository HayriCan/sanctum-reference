<?php

namespace App\Providers;

use App\Repository\Eloquent\ReferenceCodeRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\WalletRepository;
use App\Repository\ReferenceCodeRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(ReferenceCodeRepositoryInterface::class,ReferenceCodeRepository::class);
        $this->app->bind(WalletRepositoryInterface::class,WalletRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
