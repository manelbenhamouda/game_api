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

// Apply CORS middleware to all API routes
$router->group(['prefix' => 'api', 'middleware' => 'cors'], function () use ($router) {
    // Public routes for user registration and login
    $router->post('/users/register', 'UserController@register');
    $router->post('/users/login', 'UserController@login');

    // All other routes require authentication
    $router->group(['middleware' => 'auth'], function () use ($router) {
        // User routes
        $router->get('/users', 'UserController@index');
        $router->post('/users', 'UserController@store');
        $router->get('/users/{id}', 'UserController@show');
        $router->put('/users/{id}', 'UserController@update');
        $router->delete('/users/{id}', 'UserController@destroy');

        // Room routes
        $router->get('/rooms', 'RoomController@index');
        $router->post('/rooms', 'RoomController@store');
        $router->get('/rooms/{id}', 'RoomController@show');
        $router->put('/rooms/{id}', 'RoomController@update');
        $router->delete('/rooms/{id}', 'RoomController@destroy');

        // Game routes
        $router->get('/games', 'GameController@index');
        $router->post('/games', 'GameController@store');
        $router->get('/games/{id}', 'GameController@show');
        $router->put('/games/{id}', 'GameController@update');
        $router->delete('/games/{id}', 'GameController@destroy');

        // Score routes
        $router->get('/scores', 'ScoreController@index');
        $router->post('/scores', 'ScoreController@store');
        $router->get('/scores/{id}', 'ScoreController@show');
        $router->put('/scores/{id}', 'ScoreController@update');
        $router->delete('/scores/{id}', 'ScoreController@destroy');
    });
});
