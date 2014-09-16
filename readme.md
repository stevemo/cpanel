## Laravel Admin Panel

[![Build Status](https://travis-ci.org/stevemo/cpanel.png)](https://travis-ci.org/stevemo/cpanel)
[![Total Downloads](https://poser.pugx.org/stevemo/cpanel/d/total.png)](https://packagist.org/packages/stevemo/cpanel)

Laravel 4 package used to provide an admin panel with user, groups and permissions management.
This package is currently under active development.

##Features
* Cartalyst Sentry package
* Anahkiasen Former package
* Twitter Bootstrap 2.3.1
* Font-awesome 3.2.0
* Users, Groups and Permissions out of the box.
* Base controller for admin panel development
* Most of the views can be replaced by your own in the config file

##Installation
Begin by installing this package through Composer. Edit your project's `composer.json` file to require `stevemo/cpanel`.

```javascript
{
    "require": {
        "stevemo/cpanel": "dev-master"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

You need to add the following service provider. 
Open `app/config/app.php`, and add a new items to the providers array.

```php
'Former\FormerServiceProvider',
'Cartalyst\Sentry\SentryServiceProvider',
'Stevemo\Cpanel\CpanelServiceProvider',
```

Then add the following Class Aliases
```php
'Former' => 'Former\Facades\Former',
'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
```

Finally run the following command in the terminal. `php artisan cpanel:install`
This will publish the config files for Cartalyst/Sentry, Anahkiasen/Former and Stevemo/Cpanel also it will run the migration.

To create a user simply do `php artisan cpanel:user`

Done! Just go to [http://localhost/admin](http://localhost/admin) to access the admin panel.

##Missing
* Send Activation code by email when user register
* Password reset/reminder
* unit test… started reading Laravel Testing decoded ;-)
* Documentation
