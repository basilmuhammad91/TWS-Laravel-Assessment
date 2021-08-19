<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ALL ROUTES FOR CUSTOMER
Route::get('/customers', 'CustomerController@index')->name('customers');
Route::post('/customers/submit', 'CustomerController@submit')->name('customers.submit');
Route::post('/customers/update', 'CustomerController@update')->name('customers.update');
Route::get('/customers/delete/{id}', 'CustomerController@delete')->name('customers.delete');

// ALL ROUTES FOR PRODUCT
Route::get('/products', 'ProductController@index')->name('products');
Route::post('/products/submit', 'ProductController@submit')->name('products.submit');
Route::post('/products/update', 'ProductController@update')->name('products.update');
Route::get('/products/delete/{id}', 'ProductController@delete')->name('products.delete');

// ALL ROUTES FOR USER
Route::get('/users', 'UserController@index')->name('users');
Route::post('/users/submit', 'UserController@submit')->name('users.submit');
Route::post('/users/update', 'UserController@update')->name('users.update');
Route::get('/users/delete/{id}', 'UserController@delete')->name('users.delete');

// ALL ROUTES FOR SALE
Route::get('/sales', 'SaleController@index')->name('sales');
Route::post('/sales/submit', 'SaleController@submit')->name('sales.submit');
Route::get('/sales/get_quantity', 'SaleController@get_quantity_by_product_id')->name('sales.get_quantity');
Route::get('/sales/delete/{id}', 'SaleController@delete')->name('sales.delete');
Route::post('/sales/update','SaleController@update')->name('sales.update');

//REPORT
Route::get('/sales/report/{id}', 'SaleController@print_report')->name('sales.report');

Route::get('/dashboard', function(){
	return view('dashboard');
});


Route::get('/register', function() {
    return redirect('/login');
});

Route::get('/home', function() {
    return redirect('/customers');
});