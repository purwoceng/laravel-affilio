<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomePage\BannerController;
use App\Http\Controllers\HomePage\ConfigController;
use App\Http\Controllers\HomePage\ProductController;
use App\Http\Controllers\HomePage\ProductTypeController;
use App\Http\Controllers\HomePage\SupplierController;
use App\Http\Controllers\Invoice\Cancel\InvoiceCancelController;
use App\Http\Controllers\Invoice\Paid\InvoicePaidController;
use App\Http\Controllers\Invoice\Unpaid\InvoiceUnpaidController;
use App\Http\Controllers\Member\Blocked\MemberBlockedController;
use App\Http\Controllers\Member\MemberController;
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
        ->group(function() {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [PermissionController::class, 'show'])->name('detail');
        });

    // Content Configuration Menu
    Route::prefix('supplier-home')
        ->name('supplier_home.')
        ->group(function() {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
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
        ->group(function() {
            Route::get('/', [BannerController::class, 'index'])->name('index');
        });

    Route::prefix('configs')
        ->name('configs.')
        ->group(function() {
            Route::get('/', [ConfigController::class, 'index'])->name('index');
        });
});
