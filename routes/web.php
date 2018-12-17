<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
  Route::get('/', 'HomeController@index')->name('root');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/timeline', 'TimelineController@index');
  Route::get('/posts', 'PostController@index');
  Route::post('/posts', 'PostController@create');
  Route::get('/comments', 'ChatController@index');
  Route::post('/comments', 'ChatController@create');

  Route::get('/users/{user}','UserController@index')->name('users');
  Route::get('/users/{user}/follow','UserController@follow')->name('users.follow');
  Route::get('/users/{user}/unfollow','UserController@unfollow')->name('users.unfollow');

  Route::get('/channels/{channel}','ChannelController@index')->name('channels');

  Route::get('/account/channels', 'MyChannelsController@index')->name('my_channels');
  Route::post('/account/channels', 'MyChannelsController@store')->name('create_channel');
  Route::delete('/account/channels/{name}/delete', 'MyChannelsController@destroy')->name('destroy_channel');
  Route::get('/channel/start_video_time', 'ChannelController@getStartVideoTime');
  Route::put('/channel/update_numbers_members', 'ChannelController@updateNumbersOfMembers');
  Route::get('/channel/playlist', 'ChannelController@getPlaylist');
  Route::get('/channel/permissions', 'ChannelController@getStatus');
  Route::post('/channel/change_permissions','ChannelController@changePermissions');
  Route::put('/channel/removeFirstVideo', 'ChannelController@removeFirstVideo');
});
