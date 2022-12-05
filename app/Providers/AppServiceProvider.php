<?php

namespace App\Providers;

use App\Repositories\Interfaces\Member\MemberBlockedRepositoryInterface;
use App\Repositories\Interfaces\Member\MemberRepositoryInterface;
use App\Repositories\Member\MemberBlockedRepository;
use App\Repositories\Member\MemberRepository;
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
        //

        $this->app->bind(
            MemberRepositoryInterface::class,
            MemberRepository::class,
        );

        $this->app->bind(
            MemberBlockedRepositoryInterface::class,
            MemberBlockedRepository::class,
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
