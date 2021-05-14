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

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\FeedRead\RssFeedController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::group(['middleware' => 'auth'], function () {
    // User Operations
    Route::get('/dashboard',                   [UserController::class,     '_viewUserDashboard'])->name('dashboard');
    // Rss Feed Operations
    Route::get('/subscribe-to-rss',            [RssFeedController::class, '_subscribeToRssFeed'])->name('subscribe');
    Route::get('/unsubscribe-from-rss/{feed}', [RssFeedController::class, '_unsubscribeFromRssFeed'])->name('unsubscribe');
    Route::get('/feed/{feed}',                 [RssFeedController::class, '_viewRssFeed'])->name('feed');
    Route::get('/feed/{feed}/{feed_post}',     [RssFeedController::class, '_viewRssFeedPost'])->name('feed_post');
});

// Logging in and out operations.
Route::get( '/login',     [UserController::class, '_viewUserLogin'])->name('login');
Route::post('/login',     [UserController::class, '_submitUserLogin'])->name('login');
Route::get( '/logout',    [UserController::class, '_viewUserLogout'])->name('logout');
Route::get( '/register',  [UserController::class, '_viewUserRegister'])->name('register');
Route::post('/register',  [UserController::class, '_submitUserRegister'])->name('register');
