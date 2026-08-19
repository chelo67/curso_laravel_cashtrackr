<?php
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\LogoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/register', [RegisterController::class, 'index'])->name('register');
Route::post('/auth/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/auth/login', [LoginController::class, 'index'])->name('login');
Route::post('/auth/login', [LoginController::class, 'login'])->name('login.store');

Route::post('/auth/logout', [LogoutController::class, 'logout'])->name('logout.store');

Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard')->with('success', 'tu cuenta ha sido verificada correctamente');
    
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function() {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function(Request $request) {
   $request->user()->sendEmailVerificationNotification();

   return back()->with('success', 'Se ha enviado un nuevo enlace de verificación a tu correo electrónico');
})->middleware(['auth', 'throttle:1,1'])->name('verification.send');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');