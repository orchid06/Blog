<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\VerificationController;

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

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();
// Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [BlogController::class, 'index']);

Route::view('/login', 'login')->name('login');

Route::post('/search', [BlogController::class, 'search'])->name('search');

Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verify/{id}', [VerificationController::class, 'verifyWithCode'])->name('verifyWithCode');

Route::post('/email/verification-notification', [VerificationController::class, 'sendVerificationEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/verify-email/resend', [VerificationController::class, 'resend'])->name('verification.resend');


Route::prefix('user')->name('user.')->group(function () {

    Route::middleware(['guest'])->group(function () {

        Route::view('/login', 'dashboard.user.login')->name('login');
        Route::view('/register', 'dashboard.user.register')->name('register');
        Route::post('/create', [UserController::class, 'create'])->name('create');
    });

    Route::post('/user/login', [UserController::class, 'check'])->name('check');
    


    Route::middleware(['auth', 'user.verified'])->group(function () {

        Route::get('/home', [UserController::class, 'index'])->name('index');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::post('/cart', [UserController::class, 'userCart'])->name('cart');
        Route::get('/profile/{id}', [UserController::class, 'userProfile'])->name('userProfile');
        Route::post('/usrUpdate/{id}', [UserController::class, 'userUpdate'])->name('userUpdate');
        Route::get('cart/checkOut/{id}', [UserController::class, 'checkOut'])->name('checkOut');
        Route::get('/like/{blogId}', [BlogController::class, 'like'])->name('like');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {

        Route::view('/login', 'dashboard.admin.login')->name('login');
        Route::post('/check', [AdminController::class, 'check'])->name('check');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/home', [AdminController::class, 'index'])->name('index');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        Route::get('/users', [AdminController::class, 'index'])->name('users');
        Route::post('/userCreate', [AdminController::class, 'userCreate'])->name('userCreate');
        Route::post('/userUpdate/{id}', [AdminController::class, 'userUpdate'])->name('userUpdate');
        Route::get('/userDelete/{id}', [AdminController::class, 'userDelete'])->name('userDelete');

        Route::get('/blogs',       [AdminController::class, 'viewBlog'])->name('blogs');
        Route::post('/blogCreate', [BlogController::class, 'blogCreate'])->name('blogCreate');
        Route::post('/blogUpdate/{id}', [BlogController::class, 'blogUpdate'])->name('blogUpdate');
        Route::get('/blogDelete/{id}', [BlogController::class, 'blogDelete'])->name('blogDelete');

        Route::get('/search', [AdminController::class, 'search'])->name('search');

        Route::post('/{id}/toggle-active', [AdminController::class, 'toggleActive'])->name('toggleActive');
        Route::post('/email-verify/{id}', [AdminController::class, 'emailVerify'])->name('emailVerify');
        
    });
});

Route::name('product.')->group(function () {

    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
    Route::post('/additem/{id}', [ProductController::class, 'addToCart'])->name('addToCart');
    Route::get('/product/{id}', [ProductController::class, 'productDetails'])->name('page');
});

Route::name('cart.')->group(function () {

    Route::get('/cart/', [ProductController::class, 'cartIndex'])->name('index');
    Route::get('/cart/delete/{id}', [ProductController::class, 'cartProductDelete'])->name('productDelete');
    Route::post('cart/QtyUpdate/{id}', [ProductController::class, 'cartQtyUpdate'])->name('qtyUpdate');
});
