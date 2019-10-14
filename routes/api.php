<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

//Users's routes
Route::apiResource('users', 'UserController');
Route::delete('currentUser', 'UserController@deleteCurrentUser');


//Actions's routes
Route::apiResource('actions', 'ActionController');
Route::post('actions/{action}/participate', 'AssociateUserActionController@newParticipation');
