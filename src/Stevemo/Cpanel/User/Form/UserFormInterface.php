<?php namespace Stevemo\Cpanel\User\Form;

interface UserFormInterface {

    /**
     * Validate and create the user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return \StdClass
     */
    public function create(array $data);

    /**
     * Validate and log in a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $credentials
     * @param bool  $remember
     *
     * @return bool
     */
    public function login(array $credentials, $remember);

    /**
     * Register a new user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $credentials
     * @param bool  $activate
     *
     * @return bool
     */
    public function register(array $credentials, $activate);

    /**
     * Validate and update a existing user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return bool
     */
    public function update(array $data);

    /**
     * Get the validation errors
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function getErrors();
} 