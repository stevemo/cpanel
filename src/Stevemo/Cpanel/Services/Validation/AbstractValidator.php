<?php namespace Stevemo\Cpanel\Services\Validation;

use Illuminate\Validation\Factory;
use Illuminate\Support\MessageBag;

class AbstractValidator implements ValidableInterface {

    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Validation data key => value array
     *
     * @var Array
     */
    protected $data = array();

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array();

    /**
     * Custom error messages
     *
     * @var Array
     */
    protected $messages = array();

    /**
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param Factory $validator
     * @param \Illuminate\Support\MessageBag $errors
     */
    function __construct(Factory $validator, MessageBag $errors)
    {
        $this->validator = $validator;
        $this->errors = $errors;
    }


    /**
     * Add data to validation against
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     * @return $this
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Test if validation passes
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function passes()
    {
        $validator = $this->validator->make($this->data, $this->rules, $this->messages);

        if( $validator->fails() )
        {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    /**
     * Test if validation passes before create
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function validForCreate()
    {
        return $this->passes();
    }

    /**
     * Test if validation passes before update
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function validForUpdate()
    {
        return $this->passes();
    }

    /**
     * Retrieve validation errors
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }

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
    public function add($key, $message)
    {
        $this->errors->add($key, $message);
        return $this;
    }

    /**
     * Get the stored data
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}