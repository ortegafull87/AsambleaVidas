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
    return view('app.inicio.index');
});

Route::resource('admin/dashboard', 'dashboardController@estatusGeneral');
Route::resource('admin/tracks', 'TrackAdmController');
Route::resource('admin/authors','AuthorAdmController');
Route::resource('admin/albumes', 'AlbumAdmController');
Route::resource('admin/users', 'UserAdmController');

// route confirm acount.
Route::get('acount/new/{id}/goconfirm',['uses'=>'UserAdmController@goConfirm']);
Route::get('acount/new/{id}/{token}/confirm',['uses'=>'UserAdmController@confirm']);

//app
Route::get('/inicio',function(){
    return view('app.inicio.index');
});

Route::get('estudios/audios/all',['uses' => 'Aplication\Estudios\AudioController@getAll']);
Route::post('estudios/audios/{id}/toggleFavorite',['uses' => 'Aplication\Estudios\AudioController@toggleFavoriteTrack']);