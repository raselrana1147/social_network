<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\PostController;


/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register api routes for your application. These
| routes are loaded by the RouteServiceProvider.
|
*/

  /*====Authenticate route. from this section person can accomplish login, register and logout====*/ 

Route::group(['prefix' => 'auth'], function ($router) {
   Route::post('login', [AuthController::class, "login"]);
   Route::post('register',[RegisterController::class, "register"]);
   Route::post('logout', [AuthController::class, "logout"]);
});

  /*====Page related route. from this section person can call page creation and add page post route====*/ 
Route::group(['prefix' => 'page'], function ($router) {
   Route::POST('create', [PageController::class, "create"]);
   Route::POST('{page_id}/attach-post', [PostController::class, "page_post"]);
});

/*====Person related route. from this section person will get his/her feeds and add post====*/ 
Route::group(['prefix' => 'person'], function ($router) {
   Route::POST('attach-post', [PostController::class, "post"]);
   Route::get('feed', [PostController::class, "get_feed"]);

});

/*====Follow related route.From this section the person can accomplish follow another person and page====*/ 
Route::group(['prefix' => 'follow'], function ($router) {
   Route::POST('person/{person_id}', [FollowController::class, "follower"]);
   Route::POST('page/{page_id}', [PageController::class, "follower"]);
});


