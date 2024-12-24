<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});



//Route::get('/auth/redirect', function (Request $request) {
//    return Socialite::driver('yandex')->redirect();
//});
//
//Route::get('/auth/callback', function () {
//    $user = Socialite::driver('yandex')->user();
//
//    dd($user->token);
//});


