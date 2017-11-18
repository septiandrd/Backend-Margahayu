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

Route::post('/signup','UserController@RegisterUser');
Route::post('/login','UserController@authenticate');
Route::post('/saveScore','UserController@saveScore');
Route::post('/savePost','PostController@savePost');
Route::post('/saveComment','PostController@saveComment');
Route::get('/getScore','UserController@getScore');
Route::get('/getPostByModul','PostController@getPostByModul');
Route::get('/getCommentByPost','PostController@getCommentByPost');
Route::get('/user','UserController@getAuthenticatedUser');
Route::get('/logout','UserController@logout');
