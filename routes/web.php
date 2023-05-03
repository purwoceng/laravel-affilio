<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dana\FundController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Dana\RewardController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\TiketController;
use App\Http\Controllers\Member\MemberResetPin;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\GlobalSettingController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Dana\EventfundController;
use App\Http\Controllers\HomePage\BannerController;
use App\Http\Controllers\HomePage\ConfigController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\Dana\DanaPensiunController;
use App\Http\Controllers\HomePage\ProductController;
use App\Http\Controllers\Member\MemberResetPassword;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\HomePage\CsNumberController;
use App\Http\Controllers\HomePage\SupplierController;
use App\Http\Controllers\Member\MemberTypeController;
use App\Http\Controllers\Dana\EventDashboardController;
use App\Http\Controllers\Dana\PensiunDashboardController;
use App\Http\Controllers\Dana\WithdrawController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Event\EventGreetingController;
use App\Http\Controllers\HomePage\FunnelLinkController;
use App\Http\Controllers\Order\OrderCheckoutController;
use App\Http\Controllers\VideoHome\VideoHomeController;
use App\Http\Controllers\HomePage\ProductTypeController;
use App\Http\Controllers\Member\MemberAccountController;
use App\Http\Controllers\Order\OrderDashboardController;
use App\Http\Controllers\HomePage\HeaderFunnelController;
use App\Http\Controllers\Product\MarkupProductController;
use App\Http\Controllers\Supplier\SupplierListController;
use App\Http\Controllers\Supplier\SupplierCoverController;
use App\Http\Controllers\HomePage\BannerCategoryController;
use App\Http\Controllers\Product\ProductInactiveController;
use App\Http\Controllers\Product\ProductWishlistController;
use App\Http\Controllers\Invoice\Paid\InvoicePaidController;
use App\Http\Controllers\HomePage\CsNumberCategoryController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Supplier\SupplierNonactiveController;
use App\Http\Controllers\VideoTraining\VideoTrainingController;
use App\Http\Controllers\VideoTutorial\VideoTutorialController;
use App\Http\Controllers\Invoice\Cancel\InvoiceCancelController;
use App\Http\Controllers\Invoice\Unpaid\InvoiceUnpaidController;
use App\Http\Controllers\Member\Blocked\MemberBlockedController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('/');

    // Member Menu
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [MemberController::class, 'show'])->name('detail');
        Route::get('/edit/{id}', [MemberController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [MemberController::class, 'update'])->name('update');
        Route::get('/network/{id}', [MemberController::class, 'network'])->name('network');

        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/', [MemberAccountController::class, 'index'])->name('index');
            Route::post('/verification', [MemberAccountController::class, 'verification'])->name('verification');
        });

        Route::prefix('blocked')->name('blocked.')->group(function () {
            Route::get('/', [MemberBlockedController::class, 'index'])->name('index');
            Route::get('/show/{id}', [MemberBlockedController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [MemberBlockedController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [MemberBlockedController::class, 'update'])->name('update');
        });

        Route::prefix('reset-password')->name('reset-password.')->group(function () {
            Route::get('/{id}', [MemberResetPassword::class, 'resetPassword'])->name('resetPassword');
            Route::put('/update/{id}', [MemberResetPassword::class, 'updatePassword'])->name('updatePassword');
        });

        Route::prefix('reset-pin')->name('reset-pin.')->group(function () {
            Route::get('/{id}', [MemberResetPin::class, 'resetPin'])->name('resetPin');
            Route::put('/update/{id}', [MemberResetPin::class, 'updatePin'])->name('updatePin');
        });

        Route::prefix('member_type')->name('member_type.')->group(function () {
            Route::get('/', [MemberTypeController::class, 'index'])->name('index');
            Route::get('/create', [MemberTypeController::class, 'create'])->name('create');
            Route::post('/store', [MemberTypeController::class, 'store'])->name('store');
            Route::get('/show/{id}', [MemberTypeController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [MemberTypeController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [MemberTypeController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [MemberTypeController::class, 'destroy'])->name('destroy');
        });
    });

    // Orders Menu
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        Route::get('/exportexcel', [OrderController::class, 'exportexcel'])->name('exportexcel');

        Route::get('/get-dashboard', [OrderDashboardController::class, 'getDashboard'])->name('dashboard');
        Route::get('/get-order', [OrderCheckoutController::class, 'getOrder'])->name('getOrder');
        Route::post('/update-checkout-order', [OrderCheckoutController::class, 'updateOrder'])->name('updateOrder');
    });

    //Invoice Menu
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::prefix('unpaid')->name('unpaid.')->group(function () {
            Route::get('/', [InvoiceUnpaidController::class, 'index'])->name('index');
            Route::get('/show/{id}', [InvoiceUnpaidController::class, 'show'])->name('show');
        });

        Route::prefix('paid')->name('paid.')->group(function () {
            Route::get('/', [InvoicePaidController::class, 'index'])->name('index');
            Route::get('/show/{id}', [InvoicePaidController::class, 'show'])->name('show');
        });

        Route::prefix('cancel')->name('cancel.')->group(function () {
            Route::get('/', [InvoiceCancelController::class, 'index'])->name('index');
            Route::get('/show/{id}', [InvoiceCancelController::class, 'show'])->name('show');
        });
    });

    // Users Menu
    Route::prefix('users')
        ->name('users.')
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [UserController::class, 'show'])->name('detail');
        });

    // Roles Menu
    Route::prefix('roles')
        ->name('roles.')
        ->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [RoleController::class, 'show'])->name('detail');
        });

    // Permissions Menu
    Route::prefix('permissions')
        ->name('permissions.')
        ->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [PermissionController::class, 'show'])->name('detail');
        });

    // Content Configuration Menu
    Route::prefix('supplier-home')
        ->name('supplier_home.')
        ->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::get('/create', [SupplierController::class, 'create'])->name('create');
            Route::post('/store', [SupplierController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [SupplierController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [SupplierController::class, 'delete'])->name('delete');
        });

    Route::prefix('product-home')
        ->name('product_home.')
        ->group(function () {
            // Products
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
            Route::get('/avail-numbers', [ProductController::class, 'getAvailableQueueNumber'])->name('avail_numbers');

            // Categories / Types
            Route::get('/types', [ProductTypeController::class, 'index'])->name('types');
            Route::get('/types/create', [ProductTypeController::class, 'create'])->name('create_type');
            Route::post('/types/store', [ProductTypeController::class, 'store'])->name('store_type');
            Route::get('/types/edit/{id}', [ProductTypeController::class, 'edit'])->name('edit_type');
            Route::put('/types/update/{id}', [ProductTypeController::class, 'update'])->name('update_type');
            Route::get('/types/delete/{id}', [ProductTypeController::class, 'delete'])->name('delete_type');
        });

    Route::prefix('banners')
        ->name('banners.')
        ->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('index');
            Route::get('/create', [BannerController::class, 'create'])->name('create');
            Route::post('/store', [BannerController::class, 'store'])->name('store');
            Route::get('/show/{id}', [BannerController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BannerController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BannerController::class, 'destroy'])->name('destroy');

            Route::prefix('category')->name('category.')->group(function () {
                Route::get('/', [BannerCategoryController::class, 'index'])->name('index');
                Route::get('/create', [BannerCategoryController::class, 'create'])->name('create');
                Route::post('/store', [BannerCategoryController::class, 'store'])->name('store');
                Route::get('/show/{id}', [BannerCategoryController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [BannerCategoryController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [BannerCategoryController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [BannerCategoryController::class, 'destroy'])->name('destroy');
            });
        });

    Route::prefix('suppliers')
        ->name('suppliers.')
        ->group(function () {

            Route::prefix('non-active')->name('nonactive.')->group(function () {
                Route::get('/', [SupplierNonactiveController::class, 'index'])->name('index');
                Route::get('/create', [SupplierNonactiveController::class, 'create'])->name('create');
                Route::post('/store', [SupplierNonactiveController::class, 'store'])->name('store');
                Route::get('/delete/{id}', [SupplierNonactiveController::class, 'destroy'])->name('destroy');
            });
        });

    //supplier-cover
    Route::prefix('supplierscover')->name('supplierscover.')->group(function () {
        Route::get('/', [SupplierCoverController::class, 'index'])->name('index');
        Route::get('/create', [SupplierCoverController::class, 'create'])->name('create');
        Route::post('/store', [SupplierCoverController::class, 'store'])->name('store');
        Route::get('/show/{id}', [SupplierCoverController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [SupplierCoverController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SupplierCoverController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [SupplierCoverController::class, 'destroy'])->name('destroy');
    });
    //supplier-list
    Route::prefix('supplierslist')->name('supplierslist.')->group(function () {
        Route::get('/', [SupplierListController::class, 'index'])->name('index');
        Route::get('/create', [SupplierListController::class, 'create'])->name('create');
        Route::post('/store', [SupplierListController::class, 'store'])->name('store');
        Route::get('/show/{id}', [SupplierListController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [SupplierListController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SupplierListController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [SupplierListController::class, 'destroy'])->name('destroy');
    });



    //MCS NUMBER MENU
    Route::prefix('cs-number')->name('cs-number.')->group(function () {
        Route::get('/', [CsNumberController::class, 'index'])->name('index');
        Route::get('/create', [CsNumberController::class, 'create'])->name('create');
        Route::post('/store', [CsNumberController::class, 'store'])->name('store');
        Route::get('/show/{id}', [CsNumberController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [CsNumberController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CsNumberController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CsNumberController::class, 'destroy'])->name('destroy');

        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/', [CsNumberCategoryController::class, 'index'])->name('index');
            Route::get('/create', [CsNumberCategoryController::class, 'create'])->name('create');
            Route::post('/store', [CsNumberCategoryController::class, 'store'])->name('store');
            Route::get('/show/{id}', [CsNumberCategoryController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [CsNumberCategoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CsNumberCategoryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CsNumberCategoryController::class, 'destroy'])->name('destroy');
        });
    });

    // Video Tutorials
    Route::prefix('video-tutorials')
        ->name('video_tutorials.')
        ->group(function () {
            Route::get('/', [VideoTutorialController::class, 'index'])->name('index');
            Route::get('/create', [VideoTutorialController::class, 'create'])->name('create');
            Route::post('/store', [VideoTutorialController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [VideoTutorialController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [VideoTutorialController::class, 'update'])->name('update');
            Route::get('/detail/{id}', [VideoTutorialController::class, 'show'])->name('detail');
            Route::get('/delete/{id}', [VideoTutorialController::class, 'delete'])->name('delete');
        });

    //video training
    Route::prefix('video_training')
        ->name('video_training.')
        ->group(function () {
            Route::get('/', [VideoTrainingController::class, 'index'])->name('index');
            Route::get('/create', [VideoTrainingController::class, 'create'])->name('create');
            Route::post('/store', [VideoTrainingController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [VideoTrainingController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [VideoTrainingController::class, 'update'])->name('update');
            Route::get('/show/{id}', [VideoTrainingController::class, 'show'])->name('show');
            Route::get('/delete/{id}', [VideoTrainingController::class, 'destroy'])->name('destroy');
        });

    //video home
    Route::prefix('video_home')
        ->name('video_home.')
        ->group(function () {
            Route::get('/', [VideoHomeController::class, 'index'])->name('index');
            Route::get('/create', [VideoHomeController::class, 'create'])->name('create');
            Route::post('/store', [VideoHomeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [VideoHomeController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [VideoHomeController::class, 'update'])->name('update');
            Route::get('/show/{id}', [VideoHomeController::class, 'show'])->name('show');
            Route::get('/delete/{id}', [VideoHomeController::class, 'destroy'])->name('destroy');
        });

    //notifikasi
    Route::prefix('notification')
        ->name('notification.')
        ->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::get('/create', [NotificationController::class, 'create'])->name('create');
            Route::post('/store', [NotificationController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [NotificationController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [NotificationController::class, 'update'])->name('update');
            Route::get('/show/{id}', [NotificationController::class, 'show'])->name('show');
            Route::get('/delete/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('configs')
        ->name('configs.')
        ->group(function () {
            Route::get('/', [ConfigController::class, 'index'])->name('index');
        });

    Route::prefix('markup')
        ->name('markup.')
        ->group(function () {
            Route::get('/edit', [GlobalSettingController::class, 'edit'])->name('edit');
            Route::put('/update', [GlobalSettingController::class, 'update'])->name('update');
        });

    Route::prefix('markup-product')
        ->name('markup_product.')
        ->group(function () {
            Route::get('/', [MarkupProductController::class, 'index'])->name('index');
            Route::get('/edit/{id}', [MarkupProductController::class, 'edit'])->name('edit');
            Route::get('/create', [MarkupProductController::class, 'create'])->name('create');
            Route::post('/store', [MarkupProductController::class, 'store'])->name('store');
            Route::put('/update/{id}', [MarkupProductController::class, 'update'])->name('update');
            Route::get('/destroy/{id}', [MarkupProductController::class, 'destroy'])->name('destroy');
        });


    Route::prefix('categories')
        ->name('categories.')
        ->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        });

    Route::prefix('products')->name('products.')->group(function () {
        Route::prefix('wishlist')->name('wishlists.')->group(function () {
            Route::get('/', [ProductWishlistController::class, 'index'])->name('index');
            Route::get('/show/{id}', [ProductWishlistController::class, 'show'])->name('show');
        });

        Route::prefix('inactive')->name('inactive.')->group(function () {
            Route::get('/', [ProductInactiveController::class, 'index'])->name('index');
            Route::get('/create', [ProductInactiveController::class, 'create'])->name('create');
            Route::post('/store', [ProductInactiveController::class, 'store'])->name('store');
            Route::get('/delete/{id}', [ProductInactiveController::class, 'destroy'])->name('delete');
        });
    });

    Route::prefix('event')->name('event.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/store', [EventController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [EventController::class, 'destroy'])->name('destroy');
        Route::get('/show/{id}', [EventController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [EventController::class, 'update'])->name('update');
    });

    Route::prefix('tiket')->name('tiket.')->group(function () {
        Route::get('/', [TiketController::class, 'index'])->name('index');
        Route::get('/create', [TiketController::class, 'create'])->name('create');
        Route::post('/store', [TiketController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [TiketController::class, 'destroy'])->name('destroy');
        Route::get('/show/{id}', [TiketController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [TiketController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [TiketController::class, 'update'])->name('update');
    });

    //dana pensiun
    Route::prefix('pensiun')->name('pensiun.')->group(function () {
        Route::get('/', [DanaPensiunController::class, 'index'])->name('index');
        Route::get('/show/{id}', [DanaPensiunController::class, 'show'])->name('show');
        Route::get('/get-dashboard', [PensiunDashboardController::class, 'getDashboard'])->name('dashboard');
    });



    //dana reward
    Route::prefix('reward')
        ->name('reward.')
        ->group(function () {
            Route::get('/', [RewardController::class, 'index'])->name('index');
            Route::get('/show/{id}', [RewardController::class, 'show'])->name('show');
        });
    //dana acara
    Route::prefix('eventfund')
        ->name('eventfund.')
        ->group(function () {
            Route::get('/', [EventfundController::class, 'index'])->name('index');
            Route::get('/show/{id}', [EventfundController::class, 'show'])->name('show');
            Route::get('/get-dashboard', [EventDashboardController::class, 'getDashboard'])->name('dashboard');
        });

    //riwayat dana
    Route::prefix('fund')
        ->name('fund.')
        ->group(function () {
            Route::get('/', [FundController::class, 'index'])->name('index');
            Route::get('/show/{id}', [FundController::class, 'show'])->name('show');
        });

    //riwayat dana
    Route::prefix('withdraw')
        ->name('withdraw.')
        ->group(function () {
            Route::get('/', [WithdrawController::class, 'index'])->name('index');
            Route::get('/show/{id}', [WithdrawController::class, 'show'])->name('show');
        });

    // Funnel Link
    Route::prefix('funnel')
        ->name('funnel.')
        ->group(function () {
            Route::get('/', [FunnelLinkController::class, 'index'])->name('index');
            Route::get('/create', [FunnelLinkController::class, 'create'])->name('create');
            Route::post('/store', [FunnelLinkController::class, 'store'])->name('store');
            Route::get('/show/{id}', [FunnelLinkController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [FunnelLinkController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [FunnelLinkController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [FunnelLinkController::class, 'destroy'])->name('destroy');
        });

    //Header Funnelink
    Route::prefix('headerfunnel')
        ->name('headerfunnel.')
        ->group(function () {
            Route::get('/', [HeaderFunnelController::class, 'index'])->name('index');
            Route::get('/create', [HeaderFunnelController::class, 'create'])->name('create');
            Route::post('/store', [HeaderFunnelController::class, 'store'])->name('store');
            Route::get('/show/{id}', [HeaderFunnelController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [HeaderFunnelController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [HeaderFunnelController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [HeaderFunnelController::class, 'destroy'])->name('destroy');
        });

    // Greeting Event
    Route::prefix('greeting')
        ->name('greeting.')
        ->group(function () {
            Route::get('/', [EventGreetingController::class, 'index'])->name('index');
            Route::get('/create', [EventGreetingController::class, 'create'])->name('create');
            Route::post('/store', [EventGreetingController::class, 'store'])->name('store');
            Route::get('/show/{id}', [EventGreetingController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [EventGreetingController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [EventGreetingController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [EventGreetingController::class, 'destroy'])->name('destroy');
        });
});
