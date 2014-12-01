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

	//activation email view\emails.activation
	'email' => [
		'subject'  => 'Activate your account',
		'greeting' => 'Dear :name',
		'start'    => 'Please keep this email for your records. Your account information is as follows',
		'email'    => 'Email',
		'password' => 'Password',
		'end'      => 'Your account is currently inactive. You cannot use it until you visit the following link',
		'link'     => 'Activate now!',
	],
];