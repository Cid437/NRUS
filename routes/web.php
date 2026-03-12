<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [\App\Http\Controllers\ShopController::class,'index'])->name('shop.index');

Route::get('/products', [\App\Http\Controllers\ShopController::class, 'index']);

Route::view('/about', 'about');
Route::view('/contact', 'contact');

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::get('/cart', [\App\Http\Controllers\CartController::class,'index'])->name('cart.index');

/*
|--------------------------------------------------------------------------
| Product CRUD (Datatable)
|--------------------------------------------------------------------------
*/

Route::resource('products-crud', \App\Http\Controllers\ProductController::class)->except(['show']);

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('register', [RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class,'register']);

Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);

Route::post('logout', [LoginController::class,'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

Route::get('email/verify', [VerificationController::class,'notice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('email/verify/{id}/{hash}', [VerificationController::class,'verify'])
    ->middleware(['auth','signed'])
    ->name('verification.verify');

Route::post('email/resend', [VerificationController::class,'resend'])
    ->middleware(['auth','throttle:6,1'])
    ->name('verification.send');

/*
|--------------------------------------------------------------------------
| Protected Home
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
    return view('home');
})->middleware(['auth','verified'])->name('home');


/*
|--------------------------------------------------------------------------
| Charts
|--------------------------------------------------------------------------
*/

Route::get('charts/yearly', [\App\Http\Controllers\ChartController::class,'yearlySales']);
Route::get('charts/monthly', [\App\Http\Controllers\ChartController::class,'monthlySales']);
Route::get('charts/range', [\App\Http\Controllers\ChartController::class,'rangeBar']);
Route::get('charts/pie', [\App\Http\Controllers\ChartController::class,'pieProductContribution']);

Route::get('charts/view', function(){
    return view('charts.index');
});


/*
|--------------------------------------------------------------------------
| Authenticated User Features
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified'])->group(function(){

    // Reviews
    Route::post('reviews', [\App\Http\Controllers\ReviewController::class,'store'])->name('reviews.store');
    Route::get('reviews/{review}/edit', [\App\Http\Controllers\ReviewController::class,'edit'])->name('reviews.edit');
    Route::put('reviews/{review}', [\App\Http\Controllers\ReviewController::class,'update'])->name('reviews.update');

    // Transactions
    Route::post('transactions', [\App\Http\Controllers\TransactionController::class,'store'])->name('transactions.store');

    // User Profile
    Route::get('profile', [\App\Http\Controllers\ProfileController::class,'edit'])->name('profile.edit');
    Route::post('profile', [\App\Http\Controllers\ProfileController::class,'update'])->name('profile.update');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){

    Route::get('/', function(){
        return view('admin.dashboard');
    })->name('dashboard');

    /*
    | User Management
    */
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    /*
    | Product Management
    */
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show']);

    Route::get('products/trashed', [\App\Http\Controllers\Admin\ProductController::class,'trashed'])
        ->name('products.trashed');

    Route::post('products/{id}/restore', [\App\Http\Controllers\Admin\ProductController::class,'restore'])
        ->name('products.restore');

    Route::post('products/import', [\App\Http\Controllers\Admin\ProductController::class,'import'])
        ->name('products.import');

    /*
    | Review Management
    */
    Route::get('reviews', [\App\Http\Controllers\ReviewController::class,'index'])
        ->name('reviews.index');

    Route::delete('reviews/{review}', [\App\Http\Controllers\ReviewController::class,'destroy'])
        ->name('reviews.destroy');

    /*
    | Transaction Management
    */
    Route::get('transactions', [\App\Http\Controllers\TransactionController::class,'index'])
        ->name('transactions.index');

    Route::post('transactions/{transaction}/status', [\App\Http\Controllers\TransactionController::class,'updateStatus'])
        ->name('transactions.updateStatus');

});