<?php

use App\Livewire\Dashboard\DashboardComponent;
use App\Livewire\{Brands, Categories, Customers, Orders, Products, Users};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Support us
Route::get('/support-us', App\Livewire\Support\Index::class)->name('support.index');

// Login
Route::get('/login', App\Livewire\Auth\Login\Index::class)->name('login');

//Logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', DashboardComponent::class)->name('dashboard.index');

    // Users
    Route::get('/users', Users\Index::class)->name('users.index');
    Route::get('/users/create', Users\Action\Create::class)->name('users.create');
    Route::get('/users/{user}', Users\Action\Show::class)->name('users.show');
    Route::get('/users/{user}/edit', Users\Action\Edit::class)->name('users.edit');

    //Customers
    Route::get('/customers', Customers\Index::class)->name('customers.index');
    Route::get('customers/create', Customers\Action\Create::class)->name('customers.create');
    Route::get('/customers/{customers}', Customers\Action\Show::class)->name('customers.show');
    Route::get('/customers/{customers}/edit', Customers\Action\Edit::class)->name('customers.edit');

    // Brands
    Route::get('/brands', Brands\Index::class)->name('brands.index');
    Route::get('/brands/create', Brands\Action\Create::class)->name('brands.create');
    Route::get('/brands/{brand}/edit', Brands\Action\Edit::class)->name('brands.edit');

    // Categories
    Route::get('/categories', Categories\Index::class)->name('categories.index');
    Route::get('/categories/create', Categories\Action\Create::class)->name('categories.create');
    Route::get('/categories/{category}', Categories\Action\Edit::class)->name('categories.show');

    // Products
    Route::get('/products', Products\Index::class)->name('products.index');
    Route::get('/products/create', Products\Action\Create::class)->name('products.create');
    Route::get('/products/{product}/edit', Products\Action\Edit::class)->name('products.edit');

    // Orders
    Route::get('/orders', Orders\Index::class)->name('orders.index');
    Route::get('/orders/create', Orders\Action\Create::class)->name('orders.create');
    Route::get('/orders/{order}/edit', Orders\Action\Edit::class)->name('orders.edit');
});
