<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', function () {
    return view('pengunjung.welcome');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('admin/user', UserController::class);
    Route::resource('admin/category', CategoryController::class);
    Route::resource('admin/product', ProductController::class);
    Route::resource('admin/branch', BranchController::class);
    Route::resource('admin/stock', StockController::class);
    Route::resource('admin/partner', PartnerController::class);
    Route::resource('admin/kurir', KurirController::class);
    Route::resource('admin/customer', CustomerController::class);
    Route::resource('admin/transaction', TransactionController::class);

    Route::get('/admin/cetak_product', 'CetakController@cetak_product')->name('cetak.product');
    Route::get('/admin/cetak_partner', 'CetakController@cetak_partner')->name('cetak.partner');
    Route::get('/admin/cetak_branch', 'CetakController@cetak_branch')->name('cetak.branch');
    Route::get('/admin/cetak_kurir', 'CetakController@cetak_kurir')->name('cetak.kurir');
    Route::get('/admin/cetak_customer', 'CetakController@cetak_customer')->name('cetak.customer');
    Route::get('/admin/cetak_stock', 'CetakController@cetak_stock')->name('cetak.stock');
    Route::get('/admin/cetak_transaction', 'CetakController@cetak_transaction')->name('cetak.transaction');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/blank', function () {
        return view('blank');
    })->name('blank');
});

Route::group(
    ['prefix' => 'api'],
    function () {
        Route::get('/product', 'ApiProductController@showAllProduct');
        Route::get('/product/{id}', 'ApiProductController@showOneProduct');
        Route::get('/productCategory/{id}', 'ApiProductController@showProductbyCategory');
        Route::get('/category', 'ApiCategoryController@showAllCategory');
        Route::get('/mainCategory', 'ApiCategoryController@showMainCategory');
        Route::get('/subCategory/{id}', 'ApiCategoryController@showSubCategory');
        Route::post('/login', 'ApiUserController@login');
        Route::post('/kurir', 'ApiUserController@kurir');
        Route::post('/customer', 'ApiUserController@customer');
        Route::get('/branch', 'ApiBranchController@showAllBranch');
        Route::get('/productBranch/{id}', 'ApiBranchController@showProductbyBranch');
        Route::get('/showKurir/{id}', 'ApiUserController@showKurir');
        Route::get('/showCustomer/{id}', 'ApiUserController@showCustomer');
        Route::post('/editKurir/{id}', 'ApiUserController@editKurir');
        Route::post('/editCustomer/{id}', 'ApiUserController@editCustomer');
        Route::post('/saveTransaction','ApiTransactionController@saveTransaction');
        Route::get('/showTransaction/{id}','ApiTransactionController@showTransaction');
        Route::get('/showDetailTransaction/{id}','ApiTransactionController@showDetailTransaction');
    }
);

Route::post('/send-message','ContactController@sendEmail')->name('contact.send');