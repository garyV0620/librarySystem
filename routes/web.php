<?php

use App\Http\Controllers\Admin\BookMaintenanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserMaintenanceController;
use App\Http\Controllers\User\BorrowBookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return redirect('login');
});


//access this route if email is verified only
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('books.index');
        } else {
            return redirect()->route('book-list');
        }
    })->name('dashboard');

	//route for profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//access this route if email is verified and the role is admin
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('user-maintenance', [UserMaintenanceController::class, 'show'])->name('user-maintenance');

    //route for user maintenance
    Route::post('enable/{user}', [UserMaintenanceController::class, 'enable'])->name('enable-user')->withTrashed();
    Route::post('disable/{user}', [UserMaintenanceController::class, 'disable'])->name('disable-user');

    //route for book maintenance
    Route::resource('books', BookMaintenanceController::class)
            ->only(['index','store', 'edit', 'update', 'destroy']);
});

//access this route if email is verified and the role is user
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->group(function () {

    Route::get('book-list', [BorrowBookController::class, 'index'])->name('book-list');
    Route::post('borrow/{book}', [BorrowBookController::class, 'borrowBook'])->name('borrow-book');
    Route::get('borrow-list', [BorrowBookController::class, 'borrowList'])->name('borrow-list');
    Route::post('return/{book}', [BorrowBookController::class, 'returnBook'])->name('return-book');
});


//email verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

//after email is verify
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

//resend email verification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

require __DIR__.'/auth.php';
