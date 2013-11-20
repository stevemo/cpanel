<?php  namespace Stevemo\Cpanel\Controllers; 

use View, Config;

class PasswordController extends BaseController {

    /**
     * Display the reset password form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function getForgot()
    {
        return View::make(Config::get('cpanel::views.password_forgot'));
    }

} 