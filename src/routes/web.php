<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/customers');

Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');

Route::get('/customers/create', [CustomerController::class, 'create'])
    ->name('customers.create');

Route::post('/customers', [CustomerController::class, 'store'])
    ->name('customers.store');

Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
    ->whereNumber('customer')
    ->name('customers.edit');

Route::put('/customers/{customer}', [CustomerController::class, 'update'])
    ->whereNumber('customer')
    ->name('customers.update');
