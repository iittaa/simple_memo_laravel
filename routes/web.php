<?php

use App\Http\Controllers\MemoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

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

// Route::get("/", "App\Http\Controllers\Auth\LoginController@showLoginForm")->name("login.index");
Route::get("/", [LoginController::class, "showLoginForm"])->name("login.index");
// Route::get("/user", "App\Http\Controllers\Auth\RegisterController@showRegistrationForm")->name("user.register");
Route::get("/user", [RegisterController::class, "showRegistrationForm"])->name("user.register");
Route::post("/user/register", [RegisterController::class, "register"])->name("user.exec.register");

Route::group(["middleware" => ["auth"]], function(){
    Route::get("/memo", [MemoController::class, "index"])->name("memo.index");
    Route::get("/memo/add", [MemoController::class, "add"])->name("memo.add");
    // Route::get("/memo", "App\Http\Controllers\MemoController@index")->name("memo.index");
    // Route::get('/memo', function () {
    //     return view('memo');
    // })->name("memo.index");
});

Auth::routes();


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
