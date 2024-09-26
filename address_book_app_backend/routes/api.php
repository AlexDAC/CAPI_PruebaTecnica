<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/** Contacts routes */
Route::prefix('/contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index'])
        ->name('contacts.index');

    Route::post('/', [ContactController::class, 'store'])
        ->name('contacts.store');

    Route::get('/{contact}', [ContactController::class, 'show'])
        ->name('users.show');

    Route::put('/{contact}', [ContactController::class, 'update'])
        ->name('contacts.update');

    Route::delete('/{contact}', [ContactController::class, 'destroy'])
        ->name('contacts.destroy');
});