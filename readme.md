# Srizon Support

An intuitive support system with just the right amount of transparency and privacy. 
Don't just claim that you have a good support team, show it publicly.

## Installation

Pull it using git clone. 

Copy and rename the `.env.example` to `.env` then edit the `.env` file to point it to your database. Also set the other config parameter (like mailgun credentials, recaptcha keys, google analytics code etc)

Also set `MAIL_DRIVER=log` in the `.env` file

Run `composer install` and `composer update` (if required).

Then run `php artisan migrate` and `php artisan key:generate` and `php artisan db:seed` and `php artisan cache:clear` command in order to migrate the database structures.

You should be able to see a welcome page when you point your web browser to the public directory

For admin interface, go to the hidden login uri (check the route named `login` in `routes.php` file).

The person who tries to login for the first time will be prompted with the default email/password below the login screen.

Login using that info and go to users->click on user name->click on edit and set your Name, Email and Password

That users will be treated as `super user` and be able to perform super admin tasks
