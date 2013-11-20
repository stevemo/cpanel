<?php namespace Stevemo\Cpanel\User\Form;

use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\Services\Validation\ValidableInterface;
use Stevemo\Cpanel\User\Repo\UserNotFoundException;

class PasswordForm implements PasswordFormInterface {

    /**
     * @var \Stevemo\Cpanel\User\Repo\CpanelUserInterface
     */
    protected $users;

    /**
     * @var ValidableInterface
     */
    protected $validator;

    /**
     * @param ValidableInterface  $validator
     * @param CpanelUserInterface $users
     */
    public function __construct(ValidableInterface $validator, CpanelUserInterface $users)
    {
        $this->users = $users;
        $this->validator = $validator;
    }

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
    public function reset(array $creds)
    {
        try
        {
            if ($this->validator->with($creds)->passes())
            {
                $this->users->resetPassword($creds['code'],$creds['password']);
                return true;
            }
        }
        catch (UserNotFoundException $e)
        {
            $this->validator->add('UserNotFoundException',$e->getMessage());
        }

        return false;

    }

    /**
     * Get the validation errors
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->validator->errors();
    }
}