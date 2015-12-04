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

Route::get('/', 'LobbyController@lobby')->name('lobby');
// Route::get('/game/{id}', 'GameController@show');
Route::resource('game', 'GameController', ['only'=> ['show']]);

Route::controller('/api/lobby', 'Api\LobbyController');

Route::resource('cards', 'CardsController');
