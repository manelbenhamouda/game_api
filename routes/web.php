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

// Basic route to display the Lumen version
$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Grouping all API routes under the 'api' prefix
$router->group(['prefix' => 'api'], function () use ($router) {
    // Public routes for user registration and login
    $router->post('/users/register', 'UserController@register');
    $router->post('/users/login', 'UserController@login');

    // Protected routes
    $router->group(['middleware' => 'auth'], function () use ($router) {
        // User management routes
        $router->get('/users', 'UserController@index');
        $router->get('/users/{id}', 'UserController@show');
        $router->put('/users/{id}', 'UserController@update');
        $router->delete('/users/{id}', 'UserController@destroy');

        // Room management routes
        $router->post('/rooms', 'RoomController@store');
        $router->get('/rooms', 'RoomController@index');
        $router->get('/rooms/{id}', 'RoomController@show');
        $router->put('/rooms/{id}', 'RoomController@update');
        $router->delete('/rooms/{id}', 'RoomController@destroy');

        // Game management routes
        $router->post('/games', 'GameController@store');
        $router->get('/games', 'GameController@index');
        $router->get('/games/{id}', 'GameController@show');
        $router->put('/games/{id}', 'GameController@update');
        $router->delete('/games/{id}', 'GameController@destroy');

        // Score management routes
        $router->post('/scores', 'ScoreController@store');
        $router->get('/scores', 'ScoreController@index');
        $router->get('/scores/{id}', 'ScoreController@show');
        $router->put('/scores/{id}', 'ScoreController@update');
        $router->delete('/scores/{id}', 'ScoreController@destroy');
    });
});
