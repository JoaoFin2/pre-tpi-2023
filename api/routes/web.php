<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/weather', 'WeatherController@index');

$router->get('/weather/all', 'WeatherController@all');

$router->get('/weather/latest', 'WeatherController@latest');

$router->get('/weather/{year}/{month}/{day}', 'WeatherController@date');

$router->get('/weather/dates', 'WeatherController@chooseDates');


$router->get('/meteosuisse/store', 'WeatherController@addData');


$router->get('/', function () use ($router) {
    return $router->app->version();
});
