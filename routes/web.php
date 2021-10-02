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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('prodCat',  ['uses' => 'ProdCatController@showAllProdCat']);
    $router->get('prodCat/{id:[0-9]+}', ['uses' => 'ProdCatController@showOneProdCat']);
    $router->post('prodCat', ['uses' => 'ProdCatController@createProdCat']);
    $router->put('prodCat/{id}', ['uses' => 'ProdCatController@updateProdCat']);
    $router->delete('prodCat/{id:[0-9]+}', ['uses' => 'ProdCatController@deleteProdCat']);

    $router->get('prodSubCat',  ['uses' => 'ProdSubCatController@showAllProdSubCat']);
    $router->get('prodSubCat/{id:[0-9]+}', ['uses' => 'prodSubCatController@showOneprodSubCat']);
    $router->post('prodSubCat', ['uses' => 'prodSubCatController@createprodSubCat']);
    $router->put('prodSubCat/{id}', ['uses' => 'prodSubCatController@updateprodSubCat']);
    $router->delete('prodSubCat/{id:[0-9]+}', ['uses' => 'prodSubCatController@deleteprodSubCat']);
  });