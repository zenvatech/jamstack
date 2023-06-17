<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('', [App\Http\Controllers\PostController::class, 'index'])->name('posts');
    Route::resource('post', App\Http\Controllers\PostController::class)->except('index');
});


Route::prefix('test')->group(function () {
    Route::get('mail', function () {

        dump(
            Mail::raw('Hello World!', function ($msg) {
                $msg->to('mundestephane13@gmail.com')->subject('Test Email');
            })
        );
    });
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
