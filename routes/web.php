<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Member\MemberBlockController;
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

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('/');

    Route::prefix('members')->name('members.')->group(function(){
        Route::get('/', [MemberController::class, 'index'])->name('index');

        Route::prefix('blocked')->name('blocked.')->group( function() {
            Route::get('/', [MemberBlockController::class, 'index'])->name('index');
        });
    });

    // Users Menu
    Route::prefix('users')
        ->name('users.')
        ->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [UserController::class, 'show'])->name('detail');
        });

    // Roles Menu
    Route::prefix('roles')
        ->name('roles.')
        ->group(function() {
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
});
