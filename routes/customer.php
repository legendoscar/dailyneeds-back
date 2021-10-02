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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('customer',  ['uses' => 'CustController@showAllCust']);
    $router->get('customer/{id:[0-9]+}', ['uses' => 'CustController@showOneCust']);
    $router->post('customer/register', ['uses' => 'CustController@registerCust']);
    $router->post('customer/login', ['uses' => 'CustController@loginCust']);
    // $router->delete('prodCat/{id:[0-9]+}', ['uses' => 'ProdCatController@deleteProdCat']);

    });