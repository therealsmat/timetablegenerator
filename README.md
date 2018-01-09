# Timetable Generator
This is a small laravel application that assist departments to quickly generate its time table.

## Requirements
PHP 5.4+ or HHVM 3.3+, and [Composer](https://getcomposer.org/) are required.

## Installation
Clone this repository in to your work directory. You will need to run  `composer install` or `composer update` to update dependencies.
Open your .env file and change the following to your configurations
```
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
Then run `php artisan migrate` to create necessary database tables

## Usage
To quickly serve the application, run `php artisan serve` to run on the default port 8000 or `php artisan serve --port=***` to run on your preferred port.

Next, register an account or login if you already have one.

Create a department, add courses to the department, generate Time table.

## Todo
* Add comprehensive tests
* Add examination scheduling feature
* Refactor the TimeTableGenerator class to use Genetic Mutation Algorithm
* Enhance the UI with javascript (Vue.js)
* Consider General Course options
* Allow for Breaks in time table
* Format time table to taste

## Contributions
If you have a change to propose for any of the above listed features, or bugs or suggestions, please feel free to fork this project and submit a pull request.

## Final Notes
We can make this application together to reduce the burden to scheduling and time tabling across school. And **YES!**, we can make it free.

## License
The MIT License (MIT). Please see [License File](https://github.com/therealSMAT/timetablegenerator/blob/master/LICENSE) for more information.
