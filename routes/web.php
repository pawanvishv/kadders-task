<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Auth\LoginController;

// Guest routes (not authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('parents.index');
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/locations', [LocationController::class, 'fetch']);
     Route::get('/fetchChildParent', [ParentController::class, 'fetchChildParent']);


    Route::prefix('parents')->group(function () {
        Route::get('/', [ParentController::class, 'view']);
        Route::get('/create', [ParentController::class, 'create']);
        Route::post('store', [ParentController::class, 'store']);
        Route::get('{id}/show', [ParentController::class, 'show']);

        Route::get('{id}', [ParentController::class, 'edit']);
        Route::put('{id}', [ParentController::class, 'update']);
        Route::delete('{id}', [ParentController::class, 'destroy']);
        Route::post('{id}/restore', [ParentController::class, 'restore']);
        Route::delete('{id}/force', [ParentController::class, 'forceDelete']);
    });

    Route::prefix('children')->group(function () {
        Route::get('/', [ChildController::class, 'view']);
        Route::get('/create', [ChildController::class, 'create']);
        Route::post('/store', [ChildController::class, 'store']);
        Route::get('{id}', [ChildController::class, 'show']);

        Route::get('{id}', [ChildController::class, 'edit']);
        Route::put('{id}', [ChildController::class, 'update']);
        Route::delete('{id}', [ChildController::class, 'destroy']);
        Route::post('{id}/restore', [ChildController::class, 'restore']);
        Route::delete('{id}/force', [ChildController::class, 'forceDelete']);
    });
});

Route::get('/', function () {
    return redirect()->route('login');
});
