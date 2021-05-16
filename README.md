## LsRssFeedReader
This is a project for creating an RSS feed reading and subscribing system...

### Pre Requisites:

- PHP 7.3^ | 8.0
- SQLite 3.8.8^

### Setting up

Step 1: upon running git clone https://github.com/Lillam/LsRssFeedReader.git you are going to want to run: 
``` 
composer install
``` 
from the root directory as this is going to install all the base laravel components.

Step 2: you can achieve this in two ways, you can either: cp ./.env.example ./.env which will copy the example env file
or you can simply just create the .env file, either way you are going to want to paste these values in:

```
APP_NAME="Rss FeedReader"
APP_ENV=local
APP_KEY=base64:zpD+v1qpgBhNj8USl1PrLdfPWql1MWQMNXQnXxC+ycA=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_FOREIGN_KEYS=true
```

Step 3: This is a project that relies on SQLite to which we are going to want to run the following:
```
touch database/database.sqlite
```
running the above is going to generate a file in the database directory and this is going to be the 
primary source of all data entering the application.

Step 4: assuming that the SQLite database has been made... we can assume that things are good to go from here and
we can now run the following: 
```
php artisan migrate
```

### Finishing off
providing all the above has been executed, you should now be ready to run the final command, which is simply:
```
php artisan serve
```
Then head on over the url of which will have been provided in your terminal of choice, a strong chance it will be:
http://127.0.0.1:8000 or http://127.0.0.1:8080 depending on which ports you have available. 
