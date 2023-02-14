# My-eBank
## In progress
## In this website you can
* Create My-eBank profile, with two-factor authentication (password and code card).
* Manage, create edit many bank accounts.
* Transfer money between yours and other accounts safe using code card.
* See transaction history, manage it.
* See and search cryptocurrency.
* Buy, sell cryptocurrency.
* See cryptocurrency history.
## An overview of the application
### Registation and login
![register-login](https://user-images.githubusercontent.com/112757458/218491546-1c446a04-e987-478c-aad0-6efad8af3ff7.gif)
### Manage accounts
![manage-accounts](https://user-images.githubusercontent.com/112757458/218719463-9d8b01c9-97a2-418b-a485-5ccb4af8b72d.gif)
## Technologies used:
* PHP 8.1.13
* MySQL 8.0.31
* Composer 2.4
* Laravel Framework 9.47.0
* TailwindCSS
## Instructions to run the website:
* Clone this repository
* Install the required packages using the command:<br><code>composer install</code>
* Install node dependencies:<br><code>npm install</code>
* Make a copy of the <code>.env.example</code> and rename it to <code>.env</code>
* Register at https://coinmarketcap.com/api/ and get your API key.
* Enter your API key in the <code>.env</code> file.
* Create data base 'myebank'.
* Enter your database credentials in the <code>.env</code> file.
* Run <code>php artisan migrate</code> command.
* You need to run the website by running <code>php artisan serve</code> command.

