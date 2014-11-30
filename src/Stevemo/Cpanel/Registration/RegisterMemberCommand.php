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
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function getFirstName()
	{
		return $this->first_name;
	}

	/**
	 * @return mixed
	 */
	public function getLastName()
	{
		return $this->last_name;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return mixed
	 */
	public function getPasswordConfirmation()
	{
		return $this->password_confirmation;
	}


} 