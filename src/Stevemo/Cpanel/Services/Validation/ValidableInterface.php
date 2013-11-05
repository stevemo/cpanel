<?php namespace Stevemo\Cpanel\Services\Validation;


interface ValidableInterface {

    /**
     * Add data to validation against
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $input
     * @return $this
     */
    public function with(array $input);

    /**
     * Test if validation passes
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function passes();

    /**
     * Test if validation passes before create
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function validForCreate();

    /**
     * Test if validation passes before update
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function validForUpdate();

    /**
     * Retrieve validation errors
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function errors();

    /**
     * Add a message to the bag.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param string $key
     * @param string $message
     * @return $this
     */
    public function add($key, $message);

    /**
     * Get the stored data
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function getData();
}