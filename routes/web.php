<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ArrivalItemController;
use App\Http\Controllers\ArrivalStornoController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SaleStornoController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransferItemController;
use App\Http\Controllers\TransferStornoController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\ModulLocatoinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleHasPermissionsController;

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
    return view('Auth/login');
});

Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
});

Route::middleware(['auth'])->resource('users', UserController::class);
Route::middleware(['auth'])->resource('brands', BrandController::class);
Route::middleware(['auth'])->resource('supliers', SuplierController::class);
Route::middleware(['auth'])->resource('taxes', TaxController::class);
Route::middleware(['auth'])->resource('catalogs', CatalogController::class);
Route::middleware(['auth'])->resource('shops', ShopController::class);
Route::middleware(['auth'])->resource('products', ProductController::class);
Route::middleware(['auth'])->resource('roles', RoleController::class);
Route::middleware(['auth'])->resource('permissions', RoleHasPermissionsController::class);

Route::middleware(['auth'])->resource('zones', ZoneController::class);
Route::middleware(['auth'])->resource('moduls', ModulController::class);
Route::middleware(['auth'])->resource('modul-locations', ModulLocatoinController::class);

Route::middleware(['auth'])->resource('arrivals', ArrivalController::class);
Route::middleware(['auth'])->resource('arrivalstorno', ArrivalStornoController::class);
Route::middleware(['auth'])->post("arrivals/closearrival", [ArrivalController::class, "closeArrival"])->name("closeArrival");

Route::middleware(['auth'])->resource('productsearch', ProductSearchController::class);

Route::middleware(['auth'])->post("productsearch/store", [ProductSearchController::class, "store"])->name("productsearch");
Route::middleware(['auth'])->post("productsearch/index", [ProductSearchController::class, "index"])->name("advancedproductsearch");
Route::middleware(['auth'])->post("productsearch/update", [ProductSearchController::class, "update"])->name("productsearchstore");

Route::middleware(['auth'])->resource('arrivalitem', ArrivalItemController::class);

Route::middleware(['auth'])->resource('sales', SaleController::class);

Route::middleware(['auth'])->resource('cart', CartController::class);
Route::middleware(['auth'])->resource('salestorno', SaleStornoController::class);

Route::middleware(['auth'])->resource('transfer', TransferController::class);
Route::middleware(['auth'])->resource('transferitem', TransferItemController::class);
Route::middleware(['auth'])->resource('transferstorno', TransferStornoController::class);

Route::middleware(['auth'])->resource('paymenttypes', PaymentTypeController::class);


