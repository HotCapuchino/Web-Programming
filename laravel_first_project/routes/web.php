<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BindingsController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

Route::get('/', function() {
    return Auth::check() ? redirect('/app/main') : redirect('/auth/login');
});

Route::prefix('app')->middleware('auth')->group(function () {
    Route::prefix('main')->group(function () {
        Route::get('/', function () {
            return UserController::render_main();
        });

        Route::post('/edit', function (Request $request) {
            return UserController::edit_user($request);
        });
    });

    Route::prefix('bindings')->group(function () {
        Route::get('/', function () {
            return BindingsController::render_bindings();
        })->name('pages.bindings');

        Route::post('/create', function (Request $request) {
            return BindingsController::create_binding($request);
        })->name('bindings.create');

        Route::post('/edit/{id}', function (Request $request, $id) {
            return BindingsController::edit_binding($request, $id);
        });

        // Route::post('/remove/{id}'. function (Request $request, $id) {
        //     return BindingsController::remove_binding($request, $id);
        // });
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', function () {
            return UserSettingsController::render_settings();
        });

        Route::post('/edit', function (Request $request) {
            return UserSettingsController::edit_user_settings($request);
        });
    });

    Route::post('logout');
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
