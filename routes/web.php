<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::get('productos/{name}', function ($name) {
    return view('producto', ['name' => $name]);
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Category routes
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    
    // Subcategory routes
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubcategoryController::class);
    
    // Subcategory2 routes
    Route::resource('subcategories2', \App\Http\Controllers\Admin\Subcategory2Controller::class);
    
    // Subcategory3 routes
    Route::resource('subcategories3', \App\Http\Controllers\Admin\Subcategory3Controller::class);
    
    // Product routes
    Route::get('products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('products/images/{id}', [App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.images.delete');

    // Rutas para obtener subcategorías
    Route::get('categories/{category}/subcategories', function ($category) {
        return App\Models\Category::find($category)->subcategories;
    });

    Route::get('subcategories/{subcategory}/subcategories2', function ($subcategory) {
        return App\Models\Subcategory::find($subcategory)->subcategories2;
    });

    Route::get('subcategories2/{subcategory2}/subcategories3', function ($subcategory2) {
        return App\Models\Subcategory2::find($subcategory2)->subcategories3;
    });

    // Rutas para sucursales
    Route::resource('sucursales', \App\Http\Controllers\Admin\SucursalController::class);

    // Client routes
    Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class);
});
