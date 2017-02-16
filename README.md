# iCRM

Requirements:
Laravel 5.2<br />
Nginx<br />
Composer <br />
Git

Download from https://github.com/icolumnruby/iCRM<br />
to download using git:<br />
git init<br />
git pull origin master<br />

After you download, go to your website document root and run:<br />
composer update

After the update is done. Create a database to your local <br />
Update .env  and config/database.php with the database detail

php artisan migrate<br />
php artisan db:seed<br />
php artisan serve

and then open the browser to view the website.

