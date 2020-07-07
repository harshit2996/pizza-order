<?php

use Illuminate\Support\Facades\Route;

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

<<<<<<< HEAD
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'PizzaController@index')->name('welcome');
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('order', 'OrderController')->except([
        'create','index','store'
    ]);
    Route::get('userorder','OrderController@user')->name('order.user');

});

Route::group(['middleware' => ['auth','isAdmin']], function () {
    Route::get('users', 'Auth\AuthController@getUsers');
    Route::get('order','OrderController@index')->name('order.index');
    Route::get('pizza/create','OrderController@create')->name('pizza.create');
    Route::post('pizza','PizzaController@store')->name('pizza.store');
});



Route::resource('pizza', 'PizzaController')->except([
    'create','store'
]);
Route::get('getpizza','PizzaController@getPizza')->name('pizza.getpizza');
Route::post('order/create','OrderController@create')->name('order.create');
Route::post('order','OrderController@store')->name('order.store');

//Login and Logout routes...
// Route::get('login', 'Auth\AuthController@index')->name('login');
// Route::post('auth/login', 'Auth\AuthController@authenticate');
// Route::get('auth/logout', 'Auth\AuthController@logout');

// Registration routes...
// Route::get('register', 'RegisterController@index');
// Route::post('auth/register', 'RegisterController@store');
Route::get('/register/check', 'Auth\RegisterController@check');



=======
Route::get('/', function () {
    return view('welcome');
});
>>>>>>> parent of e154bf2... vue and vuetify added with login system
