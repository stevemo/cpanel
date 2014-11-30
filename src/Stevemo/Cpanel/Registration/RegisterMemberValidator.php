<?php namespace Stevemo\Cpanel\Registration;

use Laracasts\Validation\FormValidator;

class RegisterMemberValidator extends FormValidator {

	protected $rules = [
		'first_name' => 'required',
		'last_name'  => 'required',
		'email'      => 'required|email',
		'password'   => 'required|confirmed'
	];
} 