# My-eBank
## In progress
## In this website you can
* Create My-eBank profile, with two-factor authentication (password and code card).
* Create many bank accounts and edit them (change name, currency and delete them).
* Transfer money between yours and other accounts safe using code card.
* See transaction history, manage it.
* See and search cryptocurrency. (in progress)
* Buy, sell cryptocurrency and open, close short position. (in progress)
## Technologies used:
* PHP 8.1.13 (Laravel Framework 9.47.0)
* MySQL 8.0.31
## Instructions to run the website:
* Clone this repository
* Install the required packages using the command:<br>
  <code>composer install</code>
* Make a copy of the <code>.env.example</code> and rename it to <code>.env</code>
* Register at https://coinmarketcap.com/api/ and get your API key.
* Enter your API key in the <code>.env</code> file.
* Create data base 'myebank'.
* Enter your database credentials in the <code>.env</code> file.
* Run <code>php artisan migrate</code> command.
* You need to run the website by running <comand>php artisan serve</comand> command.

