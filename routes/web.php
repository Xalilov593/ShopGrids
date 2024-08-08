<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

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

Route::get('/dashboard', function () {
    return view('admin.welcome');
})->name('dashboard')->middleware('auth')->middleware(['permission:dashboard']);

Route::get('/', [\App\Http\Controllers\MainController::class, 'product_page'])->name('home');
Route::get('/product/{id}', [\App\Http\Controllers\MainController::class, 'product_detail'])->name('product.details');
Route::get('/blog', [\App\Http\Controllers\MainController::class, 'blog_page'])->name('blog.page');
Route::get('/blog/{id}', [\App\Http\Controllers\MainController::class, 'blog_detail'])->name('blog.details');
Route::get('/contact', [\App\Http\Controllers\MainController::class, 'contact_page'])->name('contact_us');
Route::get('/cart', [\App\Http\Controllers\MainController::class, 'cart_page'])->name('cart');


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');



Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/clients', [UserController::class, 'clients'])->name('clients.index');


Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::put('/roles/{role}/permissions', [RoleController::class, 'givePermissionsToRole'])->name('roles.permissions');


Route::get('regions', [RegionController::class, 'index'])->name('regions.index')->middleware(['permission:regions']);
Route::post('regions', [RegionController::class, 'store'])->name('regions.store');
Route::put('regions/{region}', [RegionController::class, 'update'])->name('regions.update');
Route::delete('regions/{region}', [RegionController::class, 'destroy'])->name('regions.destroy');

Route::get('cities', [CityController::class, 'index'])->name('cities.index');
Route::post('cities', [CityController::class, 'store'])->name('cities.store');
Route::put('cities/{city}', [CityController::class, 'update'])->name('cities.update');
Route::delete('city/{city}', [CityController::class, 'destroy'])->name('cities.destroy');

Route::resource('products', ProductController::class)->middleware(['permission:products']);

Route::resource('/blogs', \App\Http\Controllers\BlogController::class);

Route::get('stock', [StockController::class, 'index'])->name('stock.index');
Route::post('stock', [StockController::class, 'store'])->name('stock.store');
Route::put('stock/{stock}', [StockController::class, 'update'])->name('stock.update');
Route::delete('stock/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');


Route::get('index' , [StockController::class, 'pageTwo'])->name('stock.pageTwo');
