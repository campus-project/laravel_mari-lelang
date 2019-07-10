<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProvinceRepository::class, \App\Repositories\ProvinceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CityRepository::class, \App\Repositories\CityRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductTypeRepository::class, \App\Repositories\ProductTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AuctionProductRepository::class, \App\Repositories\AuctionProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TransactionRepository::class, \App\Repositories\TransactionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TopupRepository::class, \App\Repositories\TopupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BidRepository::class, \App\Repositories\BidRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WithdrawalRepository::class, \App\Repositories\WithdrawalRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AuctionProductPhotoRepository::class, \App\Repositories\AuctionProductPhotoRepositoryEloquent::class);
        //:end-bindings:
    }
}
