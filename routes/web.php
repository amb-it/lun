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

Route::get('/', 'AdController@getAds')->middleware('statistics');

Route::get('/autocomplete-address', 'AdController@getAutocompleteAddresses');

Route::post('/filter-ads', 'AdController@filterAds');
