<?php namespace Stevemo\Cpanel\User\Form;

interface PasswordFormInterface {

    /**
     * Get the validation errors
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function getErrors();

    /**
     *
     *
     * @author   Steve Montambeault
     * @link     http://stevemo.ca
     *
     * @param $email
     *
     * @return bool
     */
    public function forgot($email);

    /**
     * Reset a given user password
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $creds
     *
     * @return bool
     */
    public function reset(array $creds);

} 