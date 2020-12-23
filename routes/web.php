<?php

use Illuminate\Support\Facades\Route;

Route::get('/','WelcomeController@index');

Auth::routes(['verify' => true, 'register'=> false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/campaigns', 'CampaignController');
Route::get('/listing/campaigns', 'CampaignController@showComingCampaigns')->name('campaigns.listing');
Route::get('/campaigns/involve/{campaign}/donor/{donor}', 'CampaignDonorController@show')->name('campaigndonors.show');
Route::post('/campaigns/donors', 'CampaignDonorController@store')->name('campaigndonors.store');
Route::post('/campaigns/donors/involve/manually', 'CampaignDonorController@addDonorCampaign');
Route::patch('/camapigns/update/image/{campaign}', 'CampaignController@updateCampaignImage')->name('campaigns.upload');
Route::post('/campaign/donors/list', 'CampaignDonorController@getDonorsInCampaign');

//cities and states routes
Route::get('/cities', 'CityController@index')->name('cities');
Route::post('/citiesByState', 'CityController@citiesByState')->name('citiesbystate');
Route::get('/states', 'StateController@index')->name('states');

Route::get('/admins', 'AdminController@index')->name('admins.index');
Route::get('/admins/create', 'AdminController@create')->name('admins.create');
Route::post('/admins', 'AdminController@store')->name('admins.store');
Route::get('/admins/{user}/edit', 'AdminController@edit')->name('admins.edit');
Route::patch('/admins/{user}', 'AdminController@update')->name('admins.update');
Route::delete('/admins/{user}', 'AdminController@destroy')->name('admins.destroy');

Route::resource('/donors', 'DonorController');
Route::patch('/donors/update/picture/{donor}', 'DonorController@updateProfilePicture')->name('donors.upload');
Route::put('/donors/update/picture/{donor}', 'DonorController@updateProfilePicture')->name('donors.upload');
Route::get('/donor/register','DonorController@showregistreview')->name('donor.register');
Route::resource('/bloodbanks', 'BloodBankController');
Route::patch('/donor/campaign/{campaign}/donation', 'DonationController@update')->name('donation.update');

//Search routes
Route::get('/search/donor/{search}', 'SearchController@donors');

//Reports routes
Route::get('/reports', 'ReportController@index')->name('reports.index');
Route::get('/reports/bloodbanks', 'BloodBankController@export')->name('reports.bloodbanks');
Route::get('/reports/campiagns', 'CampaignController@export')->name('reports.campaigns');
Route::get('/reports/donors', 'DonorController@export')->name('reports.donors');
Route::get('/reports/campaigndonors/{campaignid}', 'CampaignDonorController@export')->name('reports.campaigndonor');
Route::get('/reports/donations', 'ReportController@create')->name('reports.donations');

//Quiz routes
Route::get('/blood-donation', 'QuizController@show')->name('quiz');

//filters routes
Route::get('api/donors/search', 'DonorFilterController@filterByName');
Route::get('api/donors', 'DonorFilterController@index');
Route::get('api/donors/id/{id}', 'DonorFilterController@filterById');
Route::get('/filter/donors', 'DonorFilterController@filter');

//API routes
Route::post('/api/donor/store', 'DonorController@apiStore');

