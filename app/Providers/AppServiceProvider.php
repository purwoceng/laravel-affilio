<?php

namespace App\Providers;

use App\Repositories\HomePage\ProductRepository;
use App\Repositories\Interfaces\HomePage\ProductRepositoryInterface;
use App\Repositories\Interfaces\Member\MemberBlockedRepositoryInterface;
use App\Repositories\Interfaces\Member\MemberRepositoryInterface;
use App\Repositories\Interfaces\User\PermissionRepositoryInterface;
use App\Repositories\Interfaces\User\RoleRepositoryInterface;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use App\Repositories\Member\MemberBlockedRepository;
use App\Repositories\Member\MemberRepository;
use App\Repositories\User\PermissionRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MemberRepositoryInterface::class,
            MemberRepository::class,
        );

        $this->app->bind(
            MemberBlockedRepositoryInterface::class,
            MemberBlockedRepository::class,
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class,
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class,
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');
    }
}
