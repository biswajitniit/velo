<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Subscriber\BankController;
use App\Http\Controllers\Subscriber\CompanyController;
use App\Http\Controllers\Subscriber\CustomerController;
use App\Http\Controllers\Subscriber\DashboardController;
use App\Http\Controllers\Subscriber\InvoiceController;
use App\Http\Controllers\Subscriber\ItemController;
use App\Http\Controllers\Subscriber\QuoteController;
use App\Http\Controllers\Subscriber\RegisterController;
use App\Http\Controllers\Subscriber\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group.
|
*/

/**
 * Home Page
 */
Route::get('/', function () {
    return view('home');
})->name('home');

/**
 * Laravel Authentication Routes
 * Includes:
 * - Login
 * - Register
 * - Password Reset
 * - Email Verification (if enabled)
 */
Auth::routes();

/*
|--------------------------------------------------------------------------
| Google Social Login
|--------------------------------------------------------------------------
|
| Redirects the user to Google's OAuth consent screen and handles
| the callback after successful authentication.
|
*/

/**
 * Redirect user to Google OAuth
 */
Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('auth.google.redirect');

/**
 * Handle Google OAuth callback
 */
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| Apple Social Login
|--------------------------------------------------------------------------
|
| Redirects the user to Apple's authentication page and processes
| the callback after authentication.
|
*/

/**
 * Redirect user to Apple Sign In
 */
Route::get('/auth/apple/redirect', [SocialAuthController::class, 'redirectToApple'])
    ->name('auth.apple.redirect');

/**
 * Handle Apple Sign In callback
 */
Route::get('/auth/apple/callback', [SocialAuthController::class, 'handleAppleCallback'])
    ->name('auth.apple.callback');

/**
 * Handle Apple Sign In callback
 */
Route::match(['get', 'post'], '/create-account', [RegisterController::class, 'createAccount'])
    ->name('create-account');

/**
 * Stripe Payment Routes
 */
Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
Route::get('/payment/success', [StripeController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [StripeController::class, 'cancel'])->name('payment.cancel');



Route::middleware('auth')->group(function () {

    Route::get('/subscriber/dashboard', [DashboardController::class, 'index'])->name('subscriber.dashboard');

    Route::get('/subscriber/invoices', [InvoiceController::class, 'index'])->name('subscriber.invoices');
    Route::get('/subscriber/create-invoices', [InvoiceController::class, 'create'])->name('subscriber.invoices.create');
    Route::post('/subscriber/invoices', [InvoiceController::class, 'store'])->name('subscriber.invoices.store');
    Route::get('/subscriber/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('subscriber.invoices.edit');
    Route::put('/subscriber/invoices/{invoice}', [InvoiceController::class, 'update'])->name('subscriber.invoices.update');
    Route::delete('/subscriber/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('subscriber.invoices.destroy');
    Route::post('/subscriber/invoices/bulk-action', [InvoiceController::class, 'bulkAction'])->name('subscriber.invoices.bulk');
    Route::post('/subscriber/invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('subscriber.invoices.status');

    Route::get('/subscriber/quotes', [QuoteController::class, 'index'])->name('subscriber.quotes');
    Route::get('/subscriber/create-quotes', [QuoteController::class, 'create'])->name('subscriber.quotes.create');
    Route::post('/subscriber/quotes', [QuoteController::class, 'store'])->name('subscriber.quotes.store');
    Route::get('/subscriber/quotes/{quote}/edit', [QuoteController::class, 'edit'])->name('subscriber.quotes.edit');
    Route::put('/subscriber/quotes/{quote}', [QuoteController::class, 'update'])->name('subscriber.quotes.update');
    Route::delete('/subscriber/quotes/{quote}', [QuoteController::class, 'destroy'])->name('subscriber.quotes.destroy');
    Route::post('/subscriber/quotes/bulk-action', [QuoteController::class, 'bulkAction'])->name('subscriber.quotes.bulk');
    Route::post('/subscriber/quotes/{quote}/status', [QuoteController::class, 'updateStatus'])->name('subscriber.quotes.status');
    Route::post('/subscriber/quotes/{quote}/convert-to-invoice', [QuoteController::class, 'convertToInvoice'])->name('subscriber.quotes.convert');

    Route::get('/subscriber/customers', [CustomerController::class, 'index'])->name('subscriber.customers');
    Route::post('/subscriber/customers', [CustomerController::class, 'store'])->name('subscriber.customers.store');
    Route::put('/subscriber/customers/{customer}', [CustomerController::class, 'update'])->name('subscriber.customers.update');
    Route::delete('/subscriber/customers/{customer}', [CustomerController::class, 'destroy'])->name('subscriber.customers.destroy');
    Route::post('/subscriber/customers/{customer}/status', [CustomerController::class, 'updateStatus'])->name('subscriber.customers.status');
    Route::post('/subscriber/customers/import', [CustomerController::class, 'import'])->name('subscriber.customers.import');
    Route::post('/subscriber/customers/bulk-action', [CustomerController::class, 'bulkAction'])->name('subscriber.customers.bulk');

    Route::get('/subscriber/projects', function () {
        return view('subscriber/projects');
    })->name('subscriber.projects');

    Route::get('/subscriber/items', [ItemController::class, 'index'])->name('subscriber.items');
    Route::post('/subscriber/items', [ItemController::class, 'store'])->name('subscriber.items.store');
    Route::put('/subscriber/items/{item}', [ItemController::class, 'update'])->name('subscriber.items.update');
    Route::delete('/subscriber/items/{item}', [ItemController::class, 'destroy'])->name('subscriber.items.destroy');
    Route::post('/subscriber/items/{item}/toggle', [ItemController::class, 'toggleStatus'])->name('subscriber.items.toggle');
    Route::post('/subscriber/items/bulk-action', [ItemController::class, 'bulkAction'])->name('subscriber.items.bulk');

    Route::get('/subscriber/documents', function () {
        return view('subscriber/documents');
    })->name('subscriber.documents');

    Route::get('/subscriber/notifications', function () {
        return view('subscriber/notifications');
    })->name('subscriber.notifications');

    Route::get('/subscriber/payments', function () {
        return view('subscriber/payments');
    })->name('subscriber.payments');

    Route::get('/subscriber/banks', [BankController::class, 'index'])->name('subscriber.banks');
    Route::post('/subscriber/banks', [BankController::class, 'store'])->name('subscriber.banks.store');
    Route::put('/subscriber/banks/{bank}', [BankController::class, 'update'])->name('subscriber.banks.update');
    Route::delete('/subscriber/banks/{bank}', [BankController::class, 'destroy'])->name('subscriber.banks.destroy');
    Route::post('/subscriber/banks/{bank}/primary', [BankController::class, 'setPrimary'])->name('subscriber.banks.primary');
    Route::post('/subscriber/banks/{bank}/status', [BankController::class, 'toggleStatus'])->name('subscriber.banks.status');
    Route::post('/subscriber/banks/bulk-action', [BankController::class, 'bulkAction'])->name('subscriber.banks.bulk');


    Route::get('/subscriber/company/create', [CompanyController::class, 'create'])->name('subscriber.company.create');
    Route::post('/subscriber/company', [CompanyController::class, 'store'])->name('subscriber.company.store');
    Route::get('/subscriber/settings', [SettingsController::class, 'index'])->name('settings.index');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
