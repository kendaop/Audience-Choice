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

    Route::get('/vote', 'VoteController@loginForm')->name('vote');

    Route::get('/ballot', 'VoteController@ballot')->name('ballot');

    Route::post('/submitBallot', 'VoteController@submitBallot')->name('submitBallot');

    Route::post('/login', 'VoteController@login')->name('login');
