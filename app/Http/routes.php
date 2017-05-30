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
    //return view('app.inicio.index');
    return redirect('all/audios');
});

Route::get('{filter}/audios', ['uses' => 'Aplication\Estudios\AudioController@getAll']);

Route::resource('admin/dashboard', 'dashboardController@estatusGeneral');
Route::resource('admin/tracks', 'TrackAdmController');
Route::resource('admin/authors', 'AuthorAdmController');
Route::resource('admin/albumes', 'AlbumAdmController');
Route::resource('admin/users', 'UserAdmController');

//Review
Route::get('admin/review/',['uses' => 'TrackAdmController@getListTracksByState']);
Route::get('admin/review/{filter}/tracks',['uses' => 'TrackAdmController@getListTracksByFilter']);
Route::get('admin/review/{id}/track',['uses' => 'TrackAdmController@getTrackById']);
Route::get('admin/review/{id}/track/to/autorize',['uses' => 'TrackAdmController@getTrackForReview']);
Route::get('admin/review/{filter}/track/to/update',['uses' => 'TrackAdmController@getTrackForUpdate']);
Route::post('admin/review/{id}/{status}/updateStatus',['uses' => 'TrackAdmController@updateStatusTrack']);
Route::post('admin/review/{id}/update',['uses' => 'TrackAdmController@updateTrackInReview']);
Route::post('admin/review/{id}/autorize',['uses' => 'TrackAdmController@autorizeTrackInReview']);

// route confirm acount.
Route::get('acount/new/{id}/goconfirm', ['uses' => 'UserAdmController@goConfirm']);
Route::get('acount/new/{id}/{token}/confirm', ['uses' => 'UserAdmController@confirm']);

//app
/*Route::get('/inicio', function () {
    return view('app.inicio.index');
});*/
// app audio
//Route::get('estudios/audios/all', ['uses' => 'Aplication\Estudios\AudioController@getAll']);
Route::post('estudios/audios/perPage', ['uses' => 'Aplication\Estudios\AudioController@getPerPage']);
Route::post('estudios/audios/posts/{id}/perPage', ['uses' => 'Aplication\Estudios\AudioController@getMoreComments']);
Route::post('estudios/audios/{id}/toggleFavorite', ['uses' => 'Aplication\Estudios\AudioController@toggleFavoriteTrack']);
Route::post('estudios/audios/{id}/{rate}/setRate', ['uses' => 'Aplication\Estudios\AudioController@setRate']);
Route::post('estudios/audios/{id}/setListened', ['uses' => 'Aplication\Estudios\AudioController@setListened']);
Route::get('estudios/audios/post/{id}/track', ['uses' => 'Aplication\Estudios\AudioController@getPostTrack']);
Route::post('estudios/audios/post/{id}/setPostTrack', ['uses' => 'Aplication\Estudios\AudioController@setPostTrack']);
Route::patch('estudios/audios/post/{id}/updatePostTrack', ['uses' => 'Aplication\Estudios\AudioController@updatePostTrack']);
Route::get('estudios/audios/download', ['uses' => 'Aplication\Estudios\AudioController@downloadAudio']);
Route::post('estudios/audios/post/{id}/shareMail', ['uses' => 'Aplication\Estudios\AudioController@shareMail']);

//SmartFinder
Route::post('smart/finder/findTracks', ['uses' => 'SmartFinderController@findTracks']);

// app config
Route::get('configuration/profile', ['uses' => 'Aplication\Config\ProfileController@getProfile']);
Route::patch('configuration/profile/setUpdate', ['uses' => 'Aplication\Config\ProfileController@updateProfile']);
Route::patch('configuration/profile/setAvatar', ['uses' => 'Aplication\Config\ProfileController@setAvatarAsProfileImage']);
Route::patch('configuration/profile/setImageBrows', ['uses' => 'Aplication\Config\ProfileController@setFileBrowsAsProfileImage']);
Route::patch('configuration/profile/confirmImageBrows', ['uses' => 'Aplication\Config\ProfileController@confirmImageBrows']);
Route::delete('configuration/profile/cancelImage', ['uses' => 'Aplication\Config\ProfileController@cancelUpdateImage']);
Route::patch('configuration/profile/updatePassword', ['uses' => 'Aplication\Config\ProfileController@updatePassword']);

