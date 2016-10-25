# installation 
Pull it using git clone. 

Copy and rename the `.env.example` to `.env` then edit the `.env` file to point it to your database. 

Also set `MAIL_DRIVER=log` in the `.env` file

Run `composer install` and `composer update` (if required).

Then run `php artisan migrate` and `php artisan key:generate` and `php artisan db:seed` command in order to migrate the database structures.

You should be able to see a welcome page when you point your web browser to the public directory

For admin interface, click the admin button on top right corner.

The person who tries to login for the first time will be prompted with the default email/password below the login screen.

Login using that info and go to users->click on user name->click on edit and set your Name, Email and Password

That users will be treated as `super user` and be able to perform super admin tasks

## How to use the *Permission*

You can assign roles to different permission and users to different permissions.
As a result the user will be entitled to some of the permissions via roles.
Finally, You'll have to use `permission aliases` in your code like below:

Inside Blade:

```php
@can('permission_alias')
<h2>This part is visible only to the users having permission_alias permission
@endcan

another way

@if(\Gate::allows('super_admin_task'))
<h2>Super admin task</h2>
@endif
```

Inside Controller

```php
if(\Gate::denies('super_admin_task')) // here super_admin_task is a permission alias
{
	return Redirect::to('/');
}
```