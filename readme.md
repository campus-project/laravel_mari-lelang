## Mari Lelang ##

For Final Exam

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