# Full Calendar Appointments App

## Installation guide (Windows)

### Programs

Download and install PHP, Composer, Node and NPM.

- PHP: Download php from the official website, make sure that the php command is set in your system PATH global environment variables.
- Composer: Download the installer from the official website, which will recognize PHP on the system and create the php.ini file for the settings.

Open a terminal and run the following to install Laravel:

````composer global require laravel/installer````

### Libraries

````npm install````\
````composer install````

WARNING: If you have problems installing the libraries with Composer, you can try one of these options:

- Delete the composer.lock file
- Run ````composer upgrade```` or ````composer update````
- Open the php.init file (you can find it by running ````php --ini````, if not found, reinstall PHP and Composer) and activate the extension fileinfo (uncomment the line ````extension=fileinfo````)

Run composer install again.

## Running the app

Rename the .env.example file to .env and execute the following command:

````composer run post-create-project-cmd````

### Configure the database (mysql)

- Uncomment the extension=pdo_mysql option to activate the extension.
- Create a database, e.g. in the mysql terminal: create database full_calendar
- Configure the database in your .env file, e.g:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=full_calendar
DB_USERNAME=root
DB_PASSWORD=password

Migrate the database with ````php artisan migrate````

Finally, you can run the project on two different terminals

npm run dev or npm run watch
php artisan serve

## License

[MIT license](https://opensource.org/licenses/MIT).
