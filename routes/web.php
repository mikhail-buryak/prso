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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'legals', 'middleware' => ['json.request', 'json.request.camel', 'json.response.camel']], function () use ($router) {
        $router->get('/', 'LegalsController@index');
        $router->post('/', 'LegalsController@create');
        $router->get('/{id}', 'LegalsController@get');
        $router->post('/{id}', 'LegalsController@update');
        $router->delete('/{id}', 'LegalsController@delete');
    });

    $router->group(['prefix' => 'commands', 'middleware' => ['json.request', 'json.request.camel', 'json.response.camel']], function () use ($router) {
        $router->get('/legal/{id}/objects[/max/{max}]', 'CommandsController@getObjects');
        $router->post('/legal/{id}/objects[/max/{max}]', 'CommandsController@postObjects');
    });
});
