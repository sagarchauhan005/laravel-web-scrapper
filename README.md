## Webscrapper

Webscrapper made using Laravel and Javascript for fun.

# Getting Started
1. Clone the repository
2. Run `composer update`
3. Run `npm install`
4. Run `sudo apt-get install php7.0-mysql` and install any other laravel specific dependency that your system might not have.
5. Copy .env.example to .env
6. Set up Database
    * Set up DB_HOST, DB_USERNAME, DB_PASSWORD
    * To set up database from scratch : 
        1. Run `php artisan make:database webscrapper mysql`. This will automatically create a database at the given host
        2. Run `php artisan migrate`. This shall update all the table and then you can use the project.
    * To set up using given mysql file (find it in the root folder of this project by the name of webscrapper.mysql)
        1. Upload the mysql file onto the host.
        2. It already has all the required tables.
        3. Run `php artisan reset:tables`, on a safer side, if you find any values pre-existing in the tables. It shall reset all the values.
7. Run `php artisan serve`

#Examples

Screen 1

![Imgur](https://i.imgur.com/h9PnO5G.png)

Screen 2

![Imgur](https://i.imgur.com/pdBtjhp.png)

Screen 3

![Imgur](https://i.imgur.com/anhU7PD.png)

# Author

 [Sagar Chauhan](https://twitter.com/chauhansahab005) works as a Technical Lead at [Veu](https://www.theveu.com) and [Animal Advertising Pvt Ltd](https://www.weareanimal.co).
 In his spare time, he hunts bug as a Bug Bounty Hunter.
 Follow him at [Instagram](https://www.instagram.com/chauhansahab005/), [Twitter](https://twitter.com/chauhansahab005),  [Facebook](https://facebook.com/sagar.chauhan3),
[Github](https://github.com/sagarchauhan005)

# License
MIT
