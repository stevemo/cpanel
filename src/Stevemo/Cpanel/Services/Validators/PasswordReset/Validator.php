<?php namespace Stevemo\Cpanel\Services\Validators\PasswordReset;

use Stevemo\Cpanel\Services\Validators\ValidatorService;

class Validator extends ValidatorService {

        /**
     * User validation rules
     * @var array
     */
    public static $rules = array(
        'password'   => 'required|confirmed'
    );


}