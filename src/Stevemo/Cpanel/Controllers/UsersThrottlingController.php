<?php namespace Stevemo\Cpanel\Controllers;

use Cartalyst\Sentry\Users\UserNotFoundException;
use Redirect;
use View;
use Event;
use Sentry;
use Config;
use Lang;

class UsersThrottlingController extends BaseController {


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
            $throttle = Sentry::getThrottleProvider()->findByUserId($id);
            $user = $throttle->getUser();
            return View::make(Config::get('cpanel::views.throttle_status'), compact('throttle','user'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->with('error', $e->getMessage());
        }
    }

    public function putStatus($id, $action)
    {
        try
        {
            $throttle = Sentry::getThrottleProvider()->findByUserId($id);
            $user = $throttle->getUser();

            switch ($action)
            {
                case 'ban':
                    $throttle->ban();
                    Event::fire('users.ban',array($user));
                    break;
                case 'unban':
                    $throttle->unBan();
                    Event::fire('users.unban',array($user));
                    break;
                case 'suspend':
                    $throttle->suspend();
                    Event::fire('users.suspend',array($user));
                    break;
                case 'unsuspend':
                    $throttle->unsuspend();
                    Event::fire('users.unsuspend',array($user));
                    break;
                default:
                    return Redirect::route('admin.users.index')
                        ->with('error', Lang::get('cpanel::throttle.action_not_found', array('action' => $action)));
                    break;
            }

            return Redirect::route('admin.users.index')
                ->with('success', Lang::get('cpanel::throttle.success',array('action' => $action)));

        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->with('error', $e->getMessage());
        }
    }
}