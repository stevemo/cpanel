<?php  namespace Stevemo\Cpanel\Group\Form; 

use Stevemo\Cpanel\Services\Validation\ValidableInterface;
use Stevemo\Cpanel\Group\Repo\CpanelGroupInterface;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Cartalyst\Sentry\Groups\GroupExistsException;

class GroupForm implements GroupFormInterface {


    /**
     * @var \Stevemo\Cpanel\Services\Validation\ValidableInterface
     */
    protected  $validator;

    /**
     * @var \Stevemo\Cpanel\Group\Repo\CpanelGroupInterface
     */
    protected $groups;

    /**
     * @param ValidableInterface                              $validator
     * @param \Stevemo\Cpanel\Group\Repo\CpanelGroupInterface $groups
     */
    public function __construct(ValidableInterface $validator, CpanelGroupInterface $groups)
    {
        $this->validator = $validator;
        $this->groups = $groups;
    }

    /**
     * Create a new Group
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return bool
     */
    public function create(array $data)
    {
        try
        {
            if ($this->validator->with($data)->passes())
            {
                $this->groups->create($data);
                return true;
            }
        }
        catch (GroupExistsException $e)
        {
            $this->validator->add('GroupExistsException', $e->getMessage());
        }
        catch (NameRequiredException $e)
        {
            $this->validator->add('NameRequiredException', $e->getMessage());
        }

        return false;
    }

    /**
     * Update a group
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return Bool
     */
    public function update(array $data)
    {
        try
        {
            if ($this->validator->with($data)->validForUpdate())
            {
                $this->groups->update($data);
                return true;
            }
        }
        catch (GroupExistsException $e)
        {
            $this->validator->add('GroupExistsException', $e->getMessage());
        }
        catch (NameRequiredException $e)
        {
            $this->validator->add('NameRequiredException', $e->getMessage());
        }

        return false;
    }

    /**
     * Get the validator error
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->validator->errors();
    }
}