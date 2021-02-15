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

    $router->group(['prefix' => 'units', 'middleware' => ['json.request', 'json.request.camel', 'json.response.camel']], function () use ($router) {
        $router->get('/', 'UnitsController@index');
        $router->post('/', 'UnitsController@create');
        $router->get('/{id}', 'UnitsController@get');
        $router->put('/{id}', 'UnitsController@update');
        $router->delete('/{id}', 'UnitsController@delete');
    });

    $router->group(['prefix' => 'registrars', 'middleware' => ['json.request', 'json.request.camel', 'json.response.camel']], function () use ($router) {
        $router->get('/', 'RegistrarsController@index');
        $router->post('/', 'RegistrarsController@create');
        $router->get('/{id}', 'RegistrarsController@get');
        $router->put('/{id}', 'RegistrarsController@update');
        $router->delete('/{id}', 'RegistrarsController@delete');
    });

    $router->group(['prefix' => 'commands', 'middleware' => ['json.request', 'json.request.camel', 'json.response.camel']], function () use ($router) {
        $router->get('/legal/{id}/objects[/max/{max}]', 'CommandsController@getObjects');
        $router->post('/legal/{id}/objects[/max/{max}]', 'CommandsController@postObjects');
        $router->get('/registrar/{id}/state', 'CommandsController@getTransactionsRegistrarState');
        $router->post('/registrar/{id}/state', 'CommandsController@postTransactionsRegistrarState');
        $router->get('/registrar/{id}/shifts[?from={from}[&to={to}]]', 'CommandsController@getShifts');
        $router->get('/registrar/{id}/shifts/{shift}/documents', 'CommandsController@getDocuments');
        $router->get('/registrar/{id}/shifts/last/totals', 'CommandsController@getLastShiftTotals');
    });

    $router->group(['prefix' => 'receipt', 'middleware' => ['json.request', 'json.request.camel', 'json.response.camel']], function () use ($router) {
        $router->post('/validate', 'ReceiptsController@postValidate');
        $router->post('/refund', 'ReceiptsController@postRefund');
        $router->post('/cancel', 'ReceiptsController@postCancel');
        $router->get('/transaction/fiscal/{fiscal}', 'ReceiptsController@getTransaction');
    });
});
