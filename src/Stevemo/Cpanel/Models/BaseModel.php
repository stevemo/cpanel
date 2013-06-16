<?php namespace Stevemo\Cpanel\Models;

use Validator;
use Eloquent;

abstract class BaseModel extends Eloquent {

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = array();

    /**
     * Validation messages.
     *
     * @var array
     */
    public static $messages = array();

    /**
     * Validation Error
     * @var \Illuminate\Support\MessageBag
     */
    public $error;

    /**
     * Force save.
     *
     * @var bool
     */
    protected $force = false;

    /**
     * The model's saveable attributes.
     *
     * @var array
     */
    protected $unSaveable = array();

    /**
     * [__construct description]
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  array $attributes
     * @param  Illuminate\Validation\validator $validator
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * Register event bindings.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            if ( ! $model->force)
            {
                if ($model->validate())
                {
                    $model->removeUnsavable();
                    return true;
                }
                return false;
            }
        });
    }

    /**
     * Validate the model's attributes.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @throws Admin\Lib\ValidateException
     *
     * @param  array $rules
     * @param  array $messages
     * @return Bool
     */
    public function validate(array $rules = array(), array $messages = array())
    {
        $messages = $messages ? $messages : static::$messages;
        $rules = $this->replacePlaceholder($rules ? $rules : static::$rules);

        $validator = Validator::make($this->attributes, $rules, $messages);

        if ($validator->fails())
        {
            $this->error = $validator->messages();
            return false;
        }

        $this->removeUnsavable();
        return true;
    }

    /**
     * Replace placeholder in rules
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  array $rules
     * @return array
     */
    protected function replacePlaceholder($rules)
    {
        array_walk($rules, function(&$subject)
        {
            // Replace placeholders
            $subject = stripos($subject, ':id:') !== false ? str_ireplace(':id:', $this->getKey(), $subject) : $subject;
        });

        return $rules;
    }

    /**
     * Remove unsaveable attributes
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    protected function removeUnsavable()
    {
        if ( count($this->unSaveable) > 0)
        {
            foreach ($this->unSaveable as $key)
            {
                unset($this->attributes[$key]);
            }
        }
    }

    /**
     * Save the model to the database.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  array $options
     * @return Bool
     */
    public function save(array $options = array())
    {
        $this->force = false;
        return parent::save($options);
    }

    /**
     * Force save the model to the database. Skip validation!!
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  array $options
     * @return Bool
     */
    public function forceSave(array $options = array())
    {
        $this->force = true;
        return parent::save($options);
    }

}
