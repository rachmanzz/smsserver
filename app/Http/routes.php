<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth/login', function () {
    return view('server.views.login');
});
Route::get('/login', function () {
    return redirect('/auth/login');
});
Route::controller('request/sms/controlserver','service\SmsController');
Route::controller('request/resapp','service\ResourceAplication');