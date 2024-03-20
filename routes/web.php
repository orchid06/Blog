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
        Route::get('/dislike/{blogId}', [BlogController::class, 'dislike'])->name('dislike');
        Route::get('/blog-detail/{slug}', [BlogController::class, 'blogDetail'])->name('blogDetail');
        Route::post('/comment/{id}', [BlogController::class, 'comment'])->name('comment');
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

        Route::get('/all-comments/',       [AdminController::class, 'comments'])->name('comments');
        Route::post('/comment-approve/{id}', [AdminController::class, 'commentApprove'])->name('commentApprove');
        Route::post('/comment-update/{id}', [AdminController::class, 'commentUpdate'])->name('commentUpdate');
        Route::get('/comment-decline/{id}', [AdminController::class, 'commentDecline'])->name('commentDecline');

        Route::get('view-comment/{id}' , [AdminController::class, 'viewComment'])->name('viewComment');
        
    });
});
