<?php namespace Stevemo\Cpanel\Controllers;

use View, Config, Redirect, Lang;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\User\Repo\UserNotFoundException;

class UsersThrottlingController extends BaseController {

    /**
     * @var CpanelUserInterface
     */
    private $users;

    /**
     * @param CpanelUserInterface $users
     */
    public function __construct(CpanelUserInterface $users)
    {
        $this->users = $users;
    }


    /**
     * Show the user Throttling status
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getStatus($id)
    {
        try
        {
            $throttle = $this->users->getUserThrottle($id);
            $user = $throttle->getUser();
            return View::make(Config::get('cpanel::views.throttle_status'))
                ->with('user',$user)
                ->with('throttle',$throttle);
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the throttle status for a given user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     * @param $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putStatus($id, $action)
    {
        try
        {
            $this->users->updateThrottleStatus($id,$action);
            return Redirect::route('cpanel.users.index')
                ->with('success', Lang::get('cpanel::throttle.success',array('action' => $action)));

        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error', $e->getMessage());
        }
        catch (\BadMethodCallException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error', "This method is not suported [{$action}]");
        }
    }
}