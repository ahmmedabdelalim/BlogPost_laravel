<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
use Illuminate\Routing\RouteGroup;

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
define('PAGINATION_COUNT',4);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'user'],function()
{
    Route::get('index',[ PostsController::class, 'index']);
    Route::get('show/{post}',[ PostsController::class, 'show']);
    Route::get('searchposts/{query}',[PostsController::class,'searchposts']);



    ///
    Route::get('show_category',[CategoryController::class,'show_category']);
    Route::get('categoryPosts/{slug}/posts',[CategoryController::class,'categoryPosts']);

    ////
    Route::post('comment/create',[CommentController::class,'create']);
    Route::get('comment/getComment',[CommentController::class,'getComment']);

    ///// authentication
    Route::post('login',[UserController::class,'login']);
    Route::post('register',[UserController::class,'register']);
    Route::middleware('auth:api')->group(function () {
        Route::get('user', [UserController::class,'details']);
    });

});


/////////admin

Route::group(['prefix'=>'admin' ],function (){

    Route::get('getPosts',[AdminController::class, 'getPosts']);
    Route::post('addpost',[AdminController::class,'addpost']);
    Route::post('updatepost',[AdminController::class,'updatepost']);
    Route::post('deletePost',[AdminController::class, 'deletePost']);

});
