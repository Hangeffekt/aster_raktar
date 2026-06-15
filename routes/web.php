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
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SaleStornoController;
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
    return view('index');
});

Route::resource('brands', BrandController::class);

Route::resource('supliers', SuplierController::class);

Route::resource('taxes', TaxController::class);

Route::resource('catalogs', CatalogController::class);

Route::resource('shops', ShopController::class);

Route::resource('products', ProductController::class);

Route::resource('arrivals', ArrivalController::class);
Route::post("arrivals/closearrival", [ArrivalController::class, "closeArrival"])->name("closeArrival");

Route::resource('productsearch', ProductSearchController::class);

Route::post("productsearch/store", [ProductSearchController::class, "store"])->name("productsearch");
Route::post("productsearch/index", [ProductSearchController::class, "index"])->name("advancedproductsearch");
Route::post("productsearch/update", [ProductSearchController::class, "update"])->name("productsearchstore");

Route::post("editarrival/update", [ArrivalItemController::class, "update"])->name("arrivalItemEdit");
Route::post("editarrival/delete", [ArrivalItemController::class, "destroy"])->name("arrivalItemDelete");

Route::resource('sales', SaleController::class);
Route::post("sales/history", [SaleController::class, "history"])->name("history");

Route::resource('cart', CartController::class);
Route::resource('salestorno', SaleStornoController::class);

