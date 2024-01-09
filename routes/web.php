<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\LoginController;
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


Route::prefix("admin")->middleware(["language","auth"])->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name("admin.index");

    Route::get("articles", [ArticleController::class, "index"])->name("article.index");
    Route::get("articles/create",[ArticleController::class, "create"])->name("article.create");

    Route::get("categories", [CategoryController::class, "index"])->name("category.index");
    Route::get("categories/create", [CategoryController::class, "create"])->name("category.create");
    Route::post("categories/create", [CategoryController::class, "store"]);
    Route::post("categories/change-status", [CategoryController::class, "chanceStatus"])->name("categories.changeStatus");
    Route::post("categories/change-Status", [CategoryController::class, "chanceFeatureStatus"])->name("categories.feature.changeStatus");
    Route::post("categories/delete", [CategoryController::class, "delete"])->name("category.delete");
    Route::get("categories/{id}/edit", [CategoryController::class, "edit"])->name("category.edit")->whereNumber("id"); // url'de sadece rakkamları görsün
    Route::post("categories/{id}/edit", [CategoryController::class,"update"])->whereNumber("id");



});

//Route::get('/', function () { // frontend için bıraktım
//    return view('admin.index');
//})->name("home");

// login işlemleri
Route::get("/login", [LoginController::class, "showLogin"])->name("login");
Route::post("/login",[LoginController::class,"login"]);
Route::get("/register", [LoginController::class, "showRegister"])->name("register");
Route::post("/register", [LoginController::class, "register"]);
Route::post("/logout", [LoginController::class, "logout"])->name("logout");
