<?php namespace Stevemo\Cpanel\Services\Validators\Users;

use Stevemo\Cpanel\Services\Validators\ValidatorService;

class Validator extends ValidatorService {

        /**
     * User validation rules
     * @var array
     */
    public static $rules = array(
        'first_name' => 'required',
        'last_name'  => 'required',
        'password'   => 'required|confirmed',
        'email'      => 'required|email'
    );

    /**
     * Perform validation
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @return Bool 
     */
    public function passes()
    {
        $status = parent::passes();
        unset($this->data['password_confirmation']);
        return $status;
    }

}