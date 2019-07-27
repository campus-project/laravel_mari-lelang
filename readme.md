## Mari Lelang ##

For Final Exam

**Laravel 5 example** is a tutorial application for Laravel 5.2 (in french [there](http://laravel.sillo.org/laravel-5/)).

### Installation ###

* `git clone https://gitlab.com/tanyudii/mari-lelang.git`
* `cd mari-lelang`
* `composer install`
* `php artisan key:generate`
* Create a database and inform *.env*
* `php artisan migrate --seed` to create and populate tables
* Inform *config/mail.php* for email sends
* `php artisan vendor:publish` to publish filemanager
* `php artisan serve` to start the app on http://localhost:8000/