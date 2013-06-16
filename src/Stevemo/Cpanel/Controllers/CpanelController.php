<?php namespace Stevemo\Cpanel\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

class CpanelController extends BaseController {


    public function index()
    {
        return View::make(Config::get('cpanel::views.dashboard'));
    }
    
}