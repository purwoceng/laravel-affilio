<?php

namespace App\Providers;

use App\Repositories\Content\Banner\BannerCategoryRepository;
use App\Repositories\Content\Banner\BannerRepository;
use App\Repositories\Content\CS\CsNumberCategoryRepository;
use App\Repositories\Content\CS\CsNumberRepository;
use App\Repositories\HomePage\ProductRepository;
use App\Repositories\Interfaces\Content\Banner\BannerCategoryRepositoryInterface;
use App\Repositories\Interfaces\Content\Banner\BannerRepositoryInterface;
use App\Repositories\Interfaces\Content\CS\CsNumberCategoryRepositoryInterface;
use App\Repositories\Interfaces\Content\CS\CsNumberRepositoryInterface;
use App\Repositories\Interfaces\HomePage\ProductRepositoryInterface;
use App\Repositories\Interfaces\Invoice\Cancel\InvoiceCancelRepositoryInterface;
use App\Repositories\Interfaces\Invoice\Paid\InvoicePaidRepositoryInterface;
use App\Repositories\Interfaces\Invoice\Unpaid\InvoiceUnpaidRepositoryInterface;
use App\Repositories\Interfaces\Member\Blocked\MemberBlockedRepositoryInterface;
use App\Repositories\Interfaces\Member\MemberRepositoryInterface;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use App\Repositories\Interfaces\Supplier\SupplierNonActiveRepositoryInterface;
use App\Repositories\Interfaces\User\PermissionRepositoryInterface;
use App\Repositories\Interfaces\User\RoleRepositoryInterface;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use App\Repositories\Invoice\Cancel\InvoiceCancelRepository;
use App\Repositories\Invoice\Paid\InvoicePaidRepository;
use App\Repositories\Invoice\Unpaid\InvoiceUnpaidRepository;
use App\Repositories\Member\Blocked\MemberBlockedRepository;
use App\Repositories\Member\MemberRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Supplier\SupplierNonActiveRepository;
use App\Repositories\User\PermissionRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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

        // Order Menu
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class,
        );

        // Konten
        $this->app->bind(
            BannerRepositoryInterface::class,
            BannerRepository::class,
        );

        $this->app->bind(
            BannerCategoryRepositoryInterface::class,
            BannerCategoryRepository::class,
        );

        $this->app->bind(
            CsNumberRepositoryInterface::class,
            CsNumberRepository::class,
        );

        $this->app->bind(
            CsNumberCategoryRepositoryInterface::class,
            CsNumberCategoryRepository::class,
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

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class,
        );

        $this->app->bind(
            SupplierNonActiveRepositoryInterface::class,
            SupplierNonActiveRepository::class,
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
        Schema::defaultStringLength(191);
        Blade::directive('currency',function ($expression)
        {
            return "<?php echo number_format($expression,0,',','.'); ? >";
        });

    }
}
