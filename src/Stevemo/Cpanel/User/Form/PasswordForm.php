<?php namespace Stevemo\Cpanel\User\Form;

use Event;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\Services\Validation\ValidableInterface;
use Stevemo\Cpanel\User\Repo\UserNotFoundException;
use Stevemo\Cpanel\User\UserMailerInterface;

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
     * @var \Stevemo\Cpanel\User\UserMailerInterface
     */
    protected $mailer;

    /**
     * @param ValidableInterface                       $validator
     * @param CpanelUserInterface                      $users
     * @param \Stevemo\Cpanel\User\UserMailerInterface $mailer
     */
    public function __construct(
        ValidableInterface $validator,
        CpanelUserInterface $users,
        UserMailerInterface $mailer
    )
    {
        $this->users = $users;
        $this->validator = $validator;
        $this->mailer = $mailer;
    }

    /**
     *
     *
     * @author   Steve Montambeault
     * @link     http://stevemo.ca
     *
     * @param $email
     *
     * @return void
     */
    public function forgot($email)
    {
        $user = $this->users->findByLogin($email);
        $this->mailer->sendReset($user);
        Event::fire('users.password.forgot', array($user));
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