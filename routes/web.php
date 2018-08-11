<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get("/","StaticPagesController@home")->name("home");
Route::get("/help","StaticPagesController@help")->name('help');
Route::get("/about","StaticPagesController@about")->name("about");
Route::get("/signup","UsersController@create")->name("signup");

Route::resource("/users","UsersController");

Route::get("login","SessionController@create")->name("login");
Route::post("login","SessionController@store")->name("login");
Route::delete("logout","SessionController@destroy")->name("logout");


Route::get("signup/confirm/{token}","UsersController@confirmEmail")->name("confirm_email");

Route::resource("statuses","StatusesController",['only'=>['store','destroy']]);

/**
Route::get("/users","UsersController@index")->name("user.index");
Route::get("/users/{$users}","UsersController@show")->name("user.show");
Route::get("users/create","UsersController@create")->name("user.create");
Route::post("/users","UsersController@store")->name("user.store");
Route::get("/users/{users}/edit","UsersController@edit")->name("user.eidt");
Route::put("/users/{users}","UsersController@update")->name("user.update");
Route::delete("/users/{users}","UsersController@destroy")->name("user.destroy");
 **/