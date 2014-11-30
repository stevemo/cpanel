<?php

return [
	//views\registration\create.blade.php
	'create' => [
		'header'          => 'Register',
		'label-firstname' => 'First Name:',
		'label-lastname'  => 'Last Name:',
		'label-email'     => 'Email:',
		'label-pass'      => 'Password:',
		'label-pass-conf' => 'Confirm Password:',
		'footer-text'     => 'Already have an account!',
		'link-register'   => 'Sign in!',
		'btn-register'    => 'Register'
	],

	//views\registration\success.blade.php
	'success' => [
		'header' => 'Thanks for Signing up!',
		'first'  => 'You have just been sent an email that contains a confirm link.',
		'second' => 'In order to activate your account, check your email and click on the link in that email.',
		'third'  => 'If you do not see that email in your inbox shortly, look in your spam folder.',
	],
];