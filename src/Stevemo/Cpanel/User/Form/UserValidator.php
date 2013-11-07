<?php  namespace Stevemo\Cpanel\User\Form; 

use Stevemo\Cpanel\Services\Validation\AbstractValidator;

class UserValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'first_name' => 'required',
        'last_name'  => 'required',
        'password'   => 'required|confirmed',
        'email'      => 'required|email'
    );
} 