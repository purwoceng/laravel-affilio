<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')
    ->name('v1.')
    ->group(function () {
        // Products
        Route::prefix('products')
            ->name('products.')
            ->group(function () {
                Route::get('/', [ProductController::class, 'getProducts'])->name('index');
                Route::get('/{id}', [ProductController::class, 'getProductById'])->name('detail');
            });

        // Suppliers
        Route::prefix('suppliers')
            ->name('suppliers.')
            ->group(function () {
                Route::get('/', [SupplierController::class, 'getSuppliers'])->name('index');
                Route::get('/{id}', [SupplierController::class, 'getSupplierById'])->name('detail');
            });
    });
