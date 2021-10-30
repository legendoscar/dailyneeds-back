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
use App\Http\Controllers;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('category/store',  ['uses' => 'StoreCatController@showAllStoreCat']);
    $router->get('category/store/{id:[0-9]+}', ['uses' => 'StoreCatController@getOnestorecat']);
    $router->post('category/store', ['uses' => 'StoreCatController@storeCatCreate']);
    $router->put('category/store/{id}', ['uses' => 'StoreCatController@storeCatUpdate']);
    $router->delete('category/store/{id:[0-9]+}', ['uses' => 'StoreCatController@storeCatDelete']);
    $router->get('category/store/{id:[0-9]+}/sub', ['uses' => 'StoreCatController@storecatHas']);

    $router->get('prodcat',  ['uses' => 'ProdCatController@showAllProdCat']);
    $router->get('prodcat/{id:[0-9]+}', ['uses' => 'ProdCatController@showOneProdCat']);
    $router->get('prodcat/{id:[0-9]+}/sub', ['uses' => 'ProdCatController@prodCatHas']);
    $router->post('prodcat', ['uses' => 'ProdCatController@createProdCat']);
    $router->put('prodcat/{id}', ['uses' => 'ProdCatController@updateProdCat']);
    $router->delete('prodcat/{id:[0-9]+}', ['uses' => 'ProdCatController@deleteProdCat']);

    $router->get('subprodcat',  ['uses' => 'ProdSubCatController@showAllProdSubCat']);
    $router->get('subprodcat/{id:[0-9]+}', ['uses' => 'prodSubCatController@showOneprodSubCat']);
    $router->get('subprodcat/{id:[0-9]+}/cat', ['uses' => 'prodSubCatController@prodSubCatBelongsTo']);
    $router->post('subprodcat', ['uses' => 'prodSubCatController@createprodSubCat']);
    $router->put('subprodcat/{id}', ['uses' => 'prodSubCatController@updateprodSubCat']);
    $router->delete('subprodcat/{id:[0-9]+}', ['uses' => 'prodSubCatController@deleteprodSubCat']);


    $router->get('product',  ['uses' => 'ProductsController@showAllProducts']);
    $router->get('product/{id:[0-9]+}', ['uses' => 'ProductsController@showOneproduct']);
    $router->post('product', ['uses' => 'ProductsController@createProduct']);
    $router->put('product/{id}', ['uses' => 'ProductsController@updateproduct']);
    $router->get('product/{id:[0-9]+}/cat', ['uses' => 'ProductsController@ProductBelongsTo']);
    $router->delete('product/{id:[0-9]+}', ['uses' => 'ProductsController@deleteProduct']);
  });
