<?php

use Illuminate\Http\Request;

Route::resource('clinic', 'clinicController');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
