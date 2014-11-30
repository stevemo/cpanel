<?php

return [

	// route prefix
	'prefix' => 'admin',

	/*
	|--------------------------------------------------------------------------
	| Commands for the CommandBus
	|--------------------------------------------------------------------------
	|
	|
	*/
	'commands' => [
		'register' => 'Stevemo\Cpanel\Registration\RegisterMemberCommand'
	],
];