<?php namespace Stevemo\Cpanel\Registration;

class RegisterMemberCommand {

	public $first_name;
	public $last_name;
	public $email;
	public $password;
	public $password_confirmation;

	function __construct($first_name, $last_name, $email, $password, $password_confirmation)
	{
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
		$this->password = $password;
		$this->password_confirmation = $password_confirmation;
	}

	/**
	 *
	 *
	 * @author Steve Montambeault
	 *
	 * @return array
	 */
	public function toArray()
	{
		return [
			'first_name' => $this->first_name,
			'last_name'  => $this->last_name,
			'email'      => $this->email,
			'password'   => $this->password
		];
	}

} 