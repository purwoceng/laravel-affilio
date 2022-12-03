<?php

namespace App\Providers;

use App\Repositories\Interfaces\MemberRepositoryInterface;
use App\Repositories\MemberRepository;
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
