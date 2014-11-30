<?php
Route::group([
	'namespace' => 'Stevemo\Cpanel\Controllers',
	'prefix' => Config::get('cpanel::prefix', 'admin')
], function()
{

	/*
	|--------------------------------------------------------------------------
	| Cpanel Register Routes
	|--------------------------------------------------------------------------
	|
	|
	*/
	Route::get('register', array(
		'as'   => 'cpanel.register',
		'uses' => 'RegistrationController@create'
	));

	Route::post('register', array(
		'as'   => 'cpanel.register',
		'uses' => 'RegistrationController@store'
	));


});