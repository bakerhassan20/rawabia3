<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| HOME REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::put('/password', [ProfileController::class, 'updatePassword'])
    ->name('password.update');





    /*
    |--------------------------------------------------------------------------
    | CLIENTS MODULE
    |--------------------------------------------------------------------------
    */

    Route::resource('clients', ClientController::class);

    Route::get('clients-trashed', [ClientController::class, 'trashed'])
        ->name('clients.trashed');

    Route::post('clients-restore/{id}', [ClientController::class, 'restore'])
        ->name('clients.restore');

    Route::resource('contracts', ContractController::class);

   Route::get(
    '/contracts/{contract}/installments',
    [PaymentController::class, 'getInstallments']
)->name('contracts.installments');

Route::put('/contracts/{contract}/update-installments', [
    ContractController::class,
    'updateInstallments',
])->name('contracts.update_installments');



    



    /*
    |--------------------------------------------------------------------------
    | PAYMENTS MODULE
    |--------------------------------------------------------------------------
    */

    Route::resource('payments', PaymentController::class);
    Route::get('/payments/{payment}/print', [PaymentController::class, 'print'])
    ->name('payments.print');
    

    /*
    |--------------------------------------------------------------------------
    | USERS MODULE
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | ROLES & PERMISSIONS MODULE
    |--------------------------------------------------------------------------
    */

    Route::resource('roles', RoleController::class);

    /*
    |--------------------------------------------------------------------------
    | SETTINGS MODULE
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings');

    Route::post('/settings', [SettingController::class, 'update'])
        ->name('settings.update');
});
