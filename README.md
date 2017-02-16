# iCRM

Requirements:
Laravel 5.2
Nginx
Composer 
Git

download from https://github.com/icolumnruby/iCRM
to download using git:
git init
git pull origin master

After you download, go to your website document root and run:
composer update

After the update is done. Create a database to your local 
Update .env  and config/database.php with the database detail

php artisan migrate
php artisan db:seed
php artisan serve

and then open the browser to view the website.

