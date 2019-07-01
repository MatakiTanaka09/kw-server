<?php
use KW\Infrastructure\Eloquents\UserParent;


//// 1.
Route::get('/user', function () {
    return Auth::guard('users')->id();
})->middleware('cors');
//
//// 2.
//Route::get('/message', function () {
//    return ['text' => 'Hello, ' . Auth::user()->email];
//})->middleware('auth');

Route::match(["post", "options"], "login", 'App\Http\Controllers\UserMasterAuth\LoginController@login');
Route::match(["post", "options"], "logout", 'App\Http\Controllers\UserMasterAuth\LoginController@logout');
Route::match(["get", "options"], 'api/v1/test', function () {
    return "id";
});

Route::get( '/test', function () {
    return "testtest";
});

//Route::group(['middleware' => 'cors'], function() {
//    Route::match(["post", "options"], "login", 'App\Http\Controllers\UserMasterAuth\LoginController@login');
//    Route::match(["post", "options"], "logout", 'App\Http\Controllers\UserMasterAuth\LoginController@logout');
//    Route::match(["get", "options"], 'api/v1/test', function () {
//        return "id";
//    });

//    Route::post("login", 'App\Http\Controllers\UserMasterAuth\LoginController@login');
//    Route::post("logout", 'App\Http\Controllers\UserMasterAuth\LoginController@logout');
//    Route::get('test', function () {
//        return "id";
//    });
//});
// 3.
//Auth::routes();

