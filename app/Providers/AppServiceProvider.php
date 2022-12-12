<?php

namespace App\Providers;

use App\Repositories\Interfaces\Invoice\Cancel\InvoiceCancelRepositoryInterface;
use App\Repositories\Interfaces\Invoice\Paid\InvoicePaidRepositoryInterface;
use App\Repositories\Interfaces\Invoice\Unpaid\InvoiceUnpaidRepositoryInterface;
use App\Repositories\Interfaces\Member\Blocked\MemberBlockedRepositoryInterface;
use App\Repositories\Interfaces\Member\MemberRepositoryInterface;
use App\Repositories\Interfaces\User\PermissionRepositoryInterface;
use App\Repositories\Interfaces\User\RoleRepositoryInterface;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use App\Repositories\Invoice\Cancel\InvoiceCancelRepository;
use App\Repositories\Invoice\Paid\InvoicePaidRepository;
use App\Repositories\Invoice\Unpaid\InvoiceUnpaidRepository;
use App\Repositories\Member\Blocked\MemberBlockedRepository;
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

        //Invoice
        $this->app->bind(
            InvoiceCancelRepositoryInterface::class,
            InvoiceCancelRepository::class,
        );

        $this->app->bind(
            InvoicePaidRepositoryInterface::class,
            InvoicePaidRepository::class,
        );

        $this->app->bind(
            InvoiceUnpaidRepositoryInterface::class,
            InvoiceUnpaidRepository::class,
        );
        // Manajemen Akses

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
