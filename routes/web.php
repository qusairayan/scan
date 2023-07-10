<?php

use App\Http\Controllers\front\FrontController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QusaiController;




Route::get('/', function () {
    return view('welcome');
});


Route::get('/signup', [QusaiController::class, 'CreatUser']);
Route::view('login','login');
Route::get('/as',[FrontController::class, 'front']);

Route::prefix('front')->group(function(){

    Route::get('/',[FrontController::class, 'front'])->middleware('auth');

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
