# iCRM

Requirements:<br />
MySQL <br />
PHP >= 5.5.9<br />
Laravel 5.2, requirements at https://laravel.com/docs/5.2/installation<br />
Nginx<br />
Composer <br />
Git

Download from https://github.com/icolumnruby/iCRM<br />
to download using git, go to the website directory and run:<br />
git init<br />
git pull origin master<br />

Once downloaded run:<br />
composer update

After the update is done. Create a database to your local <br />
Update .env  and config/database.php with the database detail

php artisan migrate<br />
php artisan db:seed<br />
php artisan serve

Open the browser to view the website.

