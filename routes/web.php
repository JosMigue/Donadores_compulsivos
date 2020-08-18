<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true, 'register'=> false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/campaigns/{campaign}/donors/{donor}', 'CampaignController@setDonorOnCampaign')->name('campaigns.setdonor');
Route::post('/campaigns/donors', 'CampaignController@setDonorOnCampaign')->name('campaigns.setdonor');

Route::get('/cities', 'CityController@index')->name('cities');

Route::get('/admins', 'AdminController@index')->name('admins.index');
Route::get('/admins/create', 'AdminController@create')->name('admins.create');
Route::post('/admins', 'AdminController@store')->name('admins.store');
Route::get('/admins/{user}/edit', 'AdminController@edit')->name('admins.edit');
Route::patch('/admins/{user}', 'AdminController@update')->name('admins.update');
Route::delete('/admins/{user}', 'AdminController@destroy')->name('admins.destroy');


Route::resource('/donors', 'DonorController');
Route::resource('/bloodbanks', 'BloodBankController');
Route::resource('/campaigns', 'CampaignController');
