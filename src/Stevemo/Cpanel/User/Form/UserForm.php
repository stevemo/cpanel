<?php  namespace Stevemo\Cpanel\User\Form;

use Stevemo\Cpanel\Services\Validation\ValidableInterface;
use Stevemo\Cpanel\User\Repo\UserInterface;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;

class UserForm implements UserFormInterface {

    /**
     * @var \Stevemo\Cpanel\Services\Validation\ValidableInterface
     */
    protected $validator;

    /**
     * @var \Stevemo\Cpanel\User\Repo\UserInterface
     */
    protected $users;

    /**
     * @param ValidableInterface                      $validator
     * @param \Stevemo\Cpanel\User\Repo\UserInterface $users
     */
    public function __construct(ValidableInterface $validator, UserInterface $users)
    {
        $this->validator = $validator;
        $this->users = $users;
    }

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
    public function create(array $data)
    {
        try
        {
            if ( $this->validator->with($data)->passes() )
            {
                $this->users->register($data,$data['activate']);
                return true;
            }
        }
        catch (LoginRequiredException $e)
        {
            $this->validator->add('LoginRequiredException',$e->getMessage());
        }
        catch (PasswordRequiredException $e)
        {
            $this->validator->add('PasswordRequiredException',$e->getMessage());
        }
        catch (UserExistsException $e)
        {
            $this->validator->add('UserExistsException',$e->getMessage());
        }

        return false;
    }

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
    public function update(array $data)
    {
        // TODO-Stevemo: Implement update() method.
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