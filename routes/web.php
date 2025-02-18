<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\application_controller;
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
Route::get('/login', function () {
    return view('pages.login');
})->name('login');

Route::get('/sign-up', function () {
    return view('pages.register');
})->name('sign-up');

//Route::get('/logout', [application_controller::class, 'logout'])->name('logout')->middleware(['auth', 'verified']);

Route::get('/characters', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified']);

Route::get('/users/characters', function () {
    return view('pages.saved_character');
})->middleware(['auth', 'verified']);

Route::get('/email/verify', function () {
    return view('pages.email-verification');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/characters')->with('message', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification email sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/get/characters', [application_controller::class, 'getCharacters'])->middleware(['auth', 'verified']);
Route::get('/get/character-info', [application_controller::class, 'getCharacterInfo'])->middleware(['auth', 'verified']);

Route::post('/register', [application_controller::class, 'register'])->name('register');
Route::post('/submit-login', [application_controller::class, 'login'])->name('submit-login');
Route::post('/check-character', [application_controller::class, 'checkCharacter'])->name('check-character');
Route::post('/save-character', [application_controller::class, 'saveCharacter'])->name('save-character');
Route::post('/delete-character', [application_controller::class, 'deleteCharacter'])->name('delete-character');
Route::post('/logout', [application_controller::class, 'logout'])->name('logout');