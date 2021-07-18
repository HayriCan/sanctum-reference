# Laravel Sanctum Reference App

[![GitHub issues](https://img.shields.io/github/issues/HayriCan/sanctum-reference)](https://github.com/HayriCan/sanctum-reference/issues) [![GitHub license](https://img.shields.io/github/license/HayriCan/sanctum-reference)](https://github.com/HayriCan/sanctum-reference/blob/main/LICENSE)

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)

Clone the repository

    git clone git@github.com:HayriCan/sanctum-reference.git

Switch to the repo folder

    cd sanctum-reference

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:HayriCan/sanctum-reference.git
    cd sanctum-reference
    composer install
    cp .env.example .env
    php artisan key:generate

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

# Code overview

## Dependencies

- [Laravel Sanctum](https://github.com/laravel/sanctum) - Laravel Sanctum provides a featherweight authentication system for SPAs and simple APIs.
- [Scribe](https://github.com/knuckleswtf/scribe) - Scribe helps you generate API documentation for humans from your Laravel

## Folders

- `app/Exceptions` - Contains all the exception classes
- `app/Http/Controllers` - Contains all the api controllers
- `app/Http/Requests` - Contains all the api form requests
- `app/Http/Resources` - Contains all the api json resources
- `app/Jobs` - Contains all the queueable jobs
- `app/Mail` - Contains all the mailable classes
- `app/Models` - Contains all Eloquent models
- `app/Repository` - Contains all Repository classes and Interfaces
- `app/Repository/Eloquent` - Contains all repository classes for Eloquent
- `app/Traits` - Contains all traits
- `config` - Contains all the application configuration files
- `database/migrations` - Contains all the database migrations
- `public/docs` - Contains api documentation which created by [Scribe](https://github.com/knuckleswtf/scribe)
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/Feature` - Contains all the api tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information, mailing credentials and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Accept     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|
| Optional 	| Authorization    	| Bearer {TOKEN}      	|


# Unit Test

Switch to the repo folder and create sqlite file in the database folder

    touch database/test.sqlite

After creating Sqlite database file you can run 

    composer test

With that command you can run feature tests which written for api end points

# Documentation

The pre arranged documantation file could be accessible from `http://localhost:8000/docs/index.html`.
You can overwrite this documantation with your .env variables via this command
    
    php artisan scribe:generate

## Author

[Hayri Can BARÇIN]  
Email: [Contact Me]

## License

This project is licensed under the MIT License - see the [License File](LICENSE) for details

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)
[Hayri Can BARÇIN]: <https://www.linkedin.com/in/hayricanbarcin/>
[Contact Me]: <mailto:hayricanbarcin@gmail.com>


