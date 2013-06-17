<?php namespace Stevemo\Cpanel\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Sentry;

class UserSeedCommand extends Command {

    /**
    * The console command name.
    *
    * @var string
    */
    protected $name = 'cpanel:user';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Create a new user with superuser role';

    /**
     * Exceute the console command
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    public function fire()
    {
        $this->line('Welcome to the user generator.');

        $userdata['first_name']  = $this->ask('What is your First Name?');
        $userdata['last_name']   = $this->ask('What is your Last Name?');
        $userdata['email']       = $this->ask('What is your email?');
        $userdata['password']    = $this->secret('Enter a password?');
        $userdata['permissions'] = array('superuser' => 1);

        $user = Sentry::register($userdata, true);
        $this->info('<info>User ' . $userdata['first_name'] . ' added.</info>');
    }

}
