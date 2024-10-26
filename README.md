# Full Calendar Appointments App

An appointment system built with **Laravel 9**, **VueJS 3**, and **FullCalendar 5**.

## Installation guide (Windows)

### Prerequisites

Before you begin, ensure you have the following software installed on your system:

1. **PHP**: Download from the [official PHP website](https://www.php.net/downloads). Ensure the `php` command is available in your system's PATH environment variable.
2. **Composer**: Download the installer from the [official Composer website](https://getcomposer.org/download/). This will recognize PHP on your system and create the `php.ini` file for settings.
3. **Node.js and NPM**: Download and install from the [official Node.js website](https://nodejs.org/).

### Step 1: Install Laravel

Open your terminal and run the following command to install Laravel globally:

```
composer global require laravel/installer
```

### Step 2: Install Dependencies

Navigate to your project directory and install the required libraries:

```
npm install
composer install
```

### Troubleshooting Composer Installations

If you encounter issues while installing libraries with Composer, try the following solutions:

- Delete the ````composer.lock```` file
- Run ````composer upgrade```` or ````composer update````
- Open the ````php.init```` file (you can find it by running ````php --ini````, if not found, reinstall PHP and Composer) and activate the extension ````fileinfo```` (uncomment the line ````extension=fileinfo````)

Run ````composer install```` again.

## Running the App

### Step 1: Configure Environment

Rename the ````.env.example```` file to ````.env```` and execute the following command:

````composer run post-create-project-cmd````

### Step 2: Configure the Database (MySQL)

- Uncomment the ````extension=pdo_mysql```` option in your ````php.ini```` file to activate the extension.
- Create a database, e.g. in the mysql terminal: ````create database full_calendar````
- Configure the database in your ````.env```` file, e.g:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=full_calendar
DB_USERNAME=root
DB_PASSWORD=password
```

Migrate the database with ````php artisan migrate````

### Step 3: Start the Project

You can run the project using two separate terminal instances:

- For the frontend:
```
npm run dev
```
or
```
npm run watch
```
- For the backend:
```
php artisan serve
```

## License

[MIT license](https://opensource.org/licenses/MIT).
