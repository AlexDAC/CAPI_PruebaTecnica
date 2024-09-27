<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PhoneNumberController;
use Illuminate\Support\Facades\Route;

/** Contacts routes */
Route::prefix('/contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index'])
        ->name('contacts.index');

    Route::post('/', [ContactController::class, 'store'])
        ->name('contacts.store');

    Route::get('/{contact}', [ContactController::class, 'show'])
        ->name('contacts.show');

    Route::put('/{contact}', [ContactController::class, 'update'])
        ->name('contacts.update');

    Route::delete('/{contact}', [ContactController::class, 'destroy'])
    ->name('contacts.destroy');
    
    Route::get('/{contact}/phone-numbers', [PhoneNumberController::class, 'index'])
        ->name('contact_phone_numbers.index');

    Route::post('/{contact}/phone-numbers', [PhoneNumberController::class, 'store'])
        ->name('contact_phone_numbers.store');

    Route::get('/{contact}/addresses', [AddressController::class, 'index'])
        ->name('contact_addresses.index');

    Route::post('/{contact}/addresses', [AddressController::class, 'store'])
        ->name('contact_addresses.store');

    Route::get('/{contact}/emails', [EmailController::class, 'index'])
        ->name('contact_emails.index');

    Route::post('/{contact}/emails', [EmailController::class, 'store'])
        ->name('contact_emails.store');

    Route::get('/phone-numbers/{phoneNumber}', [PhoneNumberController::class, 'show'])
        ->name('contact_phone_numbers.show');

    Route::put('/phone-numbers/{phoneNumber}', [PhoneNumberController::class, 'update'])
        ->name('contact_phone_numbers.update');
    
    Route::delete('/phone-numbers/{phoneNumber}', [PhoneNumberController::class, 'destroy'])
        ->name('contact_phone_numbers.destroy');

    Route::get('/addresses/{address}', [AddressController::class, 'show'])
        ->name('contact_addresses.show');

    Route::put('/addresses/{address}', [AddressController::class, 'update'])
        ->name('contact_addresses.update');;
    
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])
        ->name('contact_addresses.destroy');

    Route::get('/emails/{email}', [EmailController::class, 'show'])
        ->name('contact_emails.show');

    Route::put('/emails/{email}', [EmailController::class, 'update'])
        ->name('contact_emails.update');

    Route::delete('/emails/{email}', [EmailController::class, 'destroy'])
        ->name('contact_emails.destroy');
});