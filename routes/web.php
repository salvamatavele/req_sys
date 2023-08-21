<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'requests');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // users
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('users', [UsersController::class, 'index'])->name('users.index');
        Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
        Route::get('users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::post('users/store', [UsersController::class, 'store'])->name('users.store');
        Route::patch('users/update/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('users/destroy/{id}', [UsersController::class, 'delete'])->name('users.destroy');
    });
    // requests
    Route::get('requests', [RequestsController::class, 'index'])->name('requests.index');
    Route::get('requests/create', [RequestsController::class, 'create'])->name('requests.create');
    Route::post('requests', [RequestsController::class, 'store'])->name('requests.store');
    Route::get('requests/in_progress/{id}', [RequestsController::class, 'inProgress'])->name('requests.in_progress');
    Route::get('requests/done/{id}', [RequestsController::class, 'done'])->name('requests.done');
    Route::get('requests/reject/{id}', [RequestsController::class, 'reject'])->name('requests.reject');
    Route::get('requests/reset/{id}', [RequestsController::class, 'reset'])->name('requests.reset');
    Route::get('requests/send/{id}', [RequestsController::class, 'send'])->name('requests.send');
    Route::post('requests/store_send', [RequestsController::class, 'storeSend'])->name('requests.store_send');
    Route::get('requests/send_to/{id}', [RequestsController::class, 'sendTo'])->name('requests.send_to');
    Route::post('requests/store_send_to', [RequestsController::class, 'storeSendTo'])->name('requests.store_send_to');
    Route::delete('requests/{id}', [RequestsController::class, 'delete'])->name('requests.delete');
    Route::delete('user_requests/{id}', [RequestsController::class, 'deleteUserRequest'])->name('user_requests.delete');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
