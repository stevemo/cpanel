## Laravel Admin Panel

[![Build Status](https://travis-ci.org/stevemo/cpanel.png)](https://travis-ci.org/stevemo/cpanel)
[![Total Downloads](https://poser.pugx.org/stevemo/cpanel/d/total.png)](https://packagist.org/packages/stevemo/cpanel)

Laravel 4 package used to provide an admin panel with user, groups and permissions management.
This package is currently under active development.

##Features
* Cartalyst Sentry package
* [AdminLTE](https://github.com/almasaeed2010/AdminLTE) - Free Premium Admin control Panel Theme That Is Based On Bootstrap 3.x
* Twitter Bootstrap 3.1.0
* Font-awesome 3.2.0
* Users, Groups and Permissions out of the box.
* Base controller for admin panel development

##Installation
Begin by installing this package through Composer. Edit your project's `composer.json` file to require `stevemo/cpanel`.

```javascript
{
    "require": {
        "stevemo/cpanel": "dev-develop"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

You need to add the following service provider. 
Open `app/config/app.php`, and add a new items to the providers array.

```php
Cartalyst\Sentry\SentryServiceProvider
Stevemo\Cpanel\CpanelServiceProvider
```

Then add the following Class Aliases
```php
'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
```

Finally run the following command in the terminal. `php artisan cpanel:install`
This will publish the config files for Cartalyst/Sentry, Anahkiasen/Former and Stevemo/Cpanel also it will run the migration.

To create a user simply do `php artisan cpanel:user`

Done! Just go to [http://localhost/admin](http://localhost/admin) to access the admin panel.

##Missing
* unit test…
* Documentation
