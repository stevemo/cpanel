<?php  namespace Stevemo\Cpanel\User\Form; 

use Stevemo\Cpanel\Services\Validation\AbstractValidator;

class PasswordValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'password'   => 'required|confirmed',
        'code'       => 'required'
    );
} 