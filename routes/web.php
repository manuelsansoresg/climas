<?php

use App\Http\Controllers\Admin\ProductReportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleReportController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])
    ->name('home')
    ->middleware(['auth', 'check.home.roles']);


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Almacen,Vendedor,Admin'])->group(function () {
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
    Route::delete('products/{product}/delete-main-image', [App\Http\Controllers\Admin\ProductController::class, 'deleteMainImage'])->name('products.deleteMainImage');

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

    // Client routesal
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Sales routes
    Route::get('sales', [App\Http\Controllers\Admin\SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [App\Http\Controllers\Admin\SaleController::class, 'create'])->name('sales.create');
    Route::post('sales', [App\Http\Controllers\Admin\SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{sale}', [App\Http\Controllers\Admin\SaleController::class, 'show'])->name('sales.show');
    Route::get('sales/reports/list', [App\Http\Controllers\Admin\SaleController::class, 'reports'])->name('sales.reports');

    // Reportes personalizados
    Route::get('reports/products', [ProductReportController::class, 'index'])->name('reports.products');
    Route::get('reports/stock',[ProductReportController::class, 'stock'])->name('reports.stock');
    Route::get('reports/ventas',[SaleReportController::class, 'index'])->name('reports.sales');

    // Warehouse routes

    //Route::get('/sale-report', \App\Http\Livewire\Admin\SaleReport::class)->name('sale-report');

    Route::resource('product-entries', \App\Http\Controllers\Admin\ProductEntryController::class);
    Route::resource('product-sales', \App\Http\Controllers\Admin\ProductSaleController::class);
});

// API routes for product search
Route::middleware(['auth'])->group(function () {
    Route::get('/api/products/search', [App\Http\Controllers\Api\ProductController::class, 'search']);
    Route::get('/api/products/all/search', [App\Http\Controllers\Api\ProductController::class, 'searchAll']);
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/item/{itemId}/update', [CartController::class, 'updateItem'])->name('cart.item.update');
    Route::delete('/cart/item/{itemId}/remove', [CartController::class, 'removeItem'])->name('cart.item.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::get('/productos/{slug}', [HomeController::class, 'productDetail']);