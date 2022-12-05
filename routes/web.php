<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Member\MemberBlockController;
use App\Http\Controllers\Member\MemberController;
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

    Route::prefix('users')
        ->name('users.')
        ->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('index');
        });
});
