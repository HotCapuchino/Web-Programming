<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    return view('pages.main');
})->middleware('auth');

Route::prefix('app')->middleware('auth')->group(function () {
    Route::get('/main', function () {
        return view('pages.main');
    });

    Route::get('/bindings', function () {
        return view('pages.bindings');
    });

    Route::get('/settings', function () {
        return view('pages.settings');
    });
});

Route::prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('pages.login');
    })->name('auth.login');

    Route::get('/register', function () {
        return view('pages.register');
    })->name('auth.register');

    Route::post('/login', [AuthController::class, 'authentificate']);

    Route::post('/register', [AuthController::class, 'register']);
});
