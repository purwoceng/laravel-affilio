<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomePage\BannerCategoryController;
use App\Http\Controllers\HomePage\BannerController;
use App\Http\Controllers\HomePage\ConfigController;
use App\Http\Controllers\HomePage\CsNumberCategoryController;
use App\Http\Controllers\HomePage\CsNumberController;
use App\Http\Controllers\HomePage\CustomerServiceNumberController;
use App\Http\Controllers\HomePage\ProductController;
use App\Http\Controllers\HomePage\ProductTypeController;
use App\Http\Controllers\HomePage\SupplierController;
use App\Http\Controllers\Invoice\Cancel\InvoiceCancelController;
use App\Http\Controllers\Invoice\Paid\InvoicePaidController;
use App\Http\Controllers\Invoice\Unpaid\InvoiceUnpaidController;
use App\Http\Controllers\Member\Blocked\MemberBlockedController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

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

        Route::prefix('blocked')->name('blocked.')->group(function () {
            Route::get('/', [MemberBlockedController::class, 'index'])->name('index');
        });
    });

    // Orders Menu
    Route::prefix('orders')->name('orders.')->group(function() {
        Route::get('/',[OrderController::class,'index'])->name('index');
    });

    //Invoice Menu
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::prefix('unpaid')->name('unpaid.')->group(function () {
            Route::get('/', [InvoiceUnpaidController::class, 'index'])->name('index');
        });

        Route::prefix('paid')->name('paid.')->group(function () {
            Route::get('/', [InvoicePaidController::class, 'index'])->name('index');
        });

        Route::prefix('cancel')->name('cancel.')->group(function () {
            Route::get('/', [InvoiceCancelController::class, 'index'])->name('index');
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
        ->group(function() {
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

        //MCS NUMBER MENU
    Route::prefix('cs-number')->name('cs-number.')->group(function () {
        Route::get('/',[CsNumberController::class,'index'])->name('index');
        Route::get('/create',[CsNumberController::class,'create'])->name('create');
        Route::post('/store',[CsNumberController::class,'store'])->name('store');
        Route::get('/show/{id}', [CsNumberController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [CsNumberController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CsNumberController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CsNumberController::class, 'destroy'])->name('destroy');


        Route::prefix('category')->name('category.')->group(function() {
            Route::get('/',[CsNumberCategoryController::class,'index'])->name('index');
            Route::get('/create',[CsNumberCategoryController::class, 'create'])->name('create');
            Route::post('/store',[CsNumberCategoryController::class,'store'])->name('store');
            Route::get('/show/{id}', [CsNumberCategoryController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [CsNumberCategoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CsNumberCategoryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CsNumberCategoryController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('configs')
        ->name('configs.')
        ->group(function () {
            Route::get('/', [ConfigController::class, 'index'])->name('index');
        });
});
