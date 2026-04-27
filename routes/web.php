<?php

use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['prefix' => '/admin'], function () {
    Route::group(['middleware'=>'admin'], function(){

        //Dashboard
        Route::post('/save_current_entity','\App\Http\Controllers\DashboardController@setCurrentEntity');

        //Users
        Route::get('/users','\App\Http\Controllers\UserController@index')->name('users');
        Route::get('/user-form/{user_id}','\App\Http\Controllers\UserController@addEditUser');
        Route::post('/saveuser','\App\Http\Controllers\UserController@save');
        Route::post('/user/delete','\App\Http\Controllers\UserController@deleteUser');
        Route::get('/user/{user_id}','\App\Http\Controllers\UserController@viewUser');

        //Entities
        Route::get('/entities','\App\Http\Controllers\EntityController@index')->name('entities');
        Route::get('/entity-form/{entity_id}','\App\Http\Controllers\EntityController@addEditEntity');
        Route::post('/saveentity','\App\Http\Controllers\EntityController@save');
        Route::post('/entity/delete','\App\Http\Controllers\EntityController@deleteEntity');
        Route::get('/entity/{entity_id}','\App\Http\Controllers\EntityController@viewEntity');

        //Products
        Route::get('/products','\App\Http\Controllers\ProductController@index')->name('products');
        Route::get('/product-form/{product_id}','\App\Http\Controllers\ProductController@addEditProduct');
        Route::post('/saveproduct','\App\Http\Controllers\ProductController@save');
        Route::post('/product/delete','\App\Http\Controllers\ProductController@deleteProduct');
        Route::get('/product/{product_id}','\App\Http\Controllers\ProductController@viewProduct');
        Route::get('/get_products/ajax','\App\Http\Controllers\ProductController@getProducts');

        //Units
        Route::get('/units','\App\Http\Controllers\UnitController@index')->name('units');
        Route::get('/unit-form/{unit_id}','\App\Http\Controllers\UnitController@addEditUnit');
        Route::post('/saveunit','\App\Http\Controllers\UnitController@save');
        Route::post('/unit/delete','\App\Http\Controllers\UnitController@deleteUnit');
        Route::get('/unit/{unit_id}','\App\Http\Controllers\UnitController@viewUnit');

        //Currencies
        Route::get('/currencies','\App\Http\Controllers\CurrencyController@index')->name('currencies');
        Route::get('/currency-form/{currency_id}','\App\Http\Controllers\CurrencyController@addEditCurrency');
        Route::post('/savecurrency','\App\Http\Controllers\CurrencyController@save');
        Route::post('/currency/delete','\App\Http\Controllers\CurrencyController@deleteCurrency');
        Route::get('/currency/{currency_id}','\App\Http\Controllers\CurrencyController@viewCurrency');

        //Settings
        Route::get('/settings','\App\Http\Controllers\SettingsController@index')->name('settings');
        Route::get('/setting-form/{setting_id}','\App\Http\Controllers\SettingsController@addEditSetting');
        Route::post('/savesetting','\App\Http\Controllers\SettingsController@save');
        Route::post('/setting/delete','\App\Http\Controllers\SettingsController@deleteSetting');
        Route::get('/setting/{setting_id}','\App\Http\Controllers\SettingsController@viewSetting');

        //Sale (Invoices/Bills)
        Route::get('/invoices','\App\Http\Controllers\InvoicesController@index')->name('invoices');
        Route::get('/invoice-form/{invoice_id}','\App\Http\Controllers\InvoicesController@addEditInvoice');
        Route::post('/saveinvoice','\App\Http\Controllers\InvoicesController@save');
        Route::post('/invoice/delete','\App\Http\Controllers\InvoicesController@deleteInvoice');
        Route::get('/invoice/{invoice_id}','\App\Http\Controllers\InvoicesController@viewInvoice');
        Route::get('/invoice/{id}/download','\App\Http\Controllers\InvoicesController@downloadInvoicePDF')->name('invoice.download');
        Route::get('/get_invoice_amount/ajax/{invoice_id}','\App\Http\Controllers\InvoicesController@getInvoiceAmount');
        Route::get('/get_invoices/ajax/{entity_id}','\App\Http\Controllers\InvoicesController@getInvoices');
        Route::get('/export/invoices','\App\Http\Controllers\InvoicesController@exportInvoices');
        Route::get('/export/invoices_by_date','\App\Http\Controllers\InvoicesController@exportInvoicesByDate');

        //Accounts
        Route::get('/accounts','\App\Http\Controllers\AccountController@index')->name('accounts');
        Route::get('/account-form/{account_id}','\App\Http\Controllers\AccountController@addEditAccount');
        Route::post('/saveaccount','\App\Http\Controllers\AccountController@save');
        Route::post('/account/delete','\App\Http\Controllers\AccountController@deleteAccount');
        Route::get('/account/{account_id}','\App\Http\Controllers\AccountController@viewAccount');

        //Transactions
        Route::get('/transactions','\App\Http\Controllers\TransactionController@index')->name('transactions');
        Route::get('/transaction-form/{transaction_id}','\App\Http\Controllers\TransactionController@addEditTransaction');
        Route::post('/savetransaction','\App\Http\Controllers\TransactionController@save');
        Route::post('/transaction/delete','\App\Http\Controllers\TransactionController@deleteTransaction');
        Route::get('/transaction/{account_id}','\App\Http\Controllers\TransactionController@viewTransaction');
    });
});


require __DIR__.'/auth.php';
