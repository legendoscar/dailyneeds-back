<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where we can register all of the routes for restaturants.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('restaurants',  ['uses' => 'RestaurantController@showAllrestaurants']);
  
    $router->get('restaurants/{id}', ['uses' => 'RestaurantController@showOneRestaurant']);
  
    $router->post('restaurants', ['uses' => 'RestaurantController@create']);
  
    $router->delete('restaurants/{id}', ['uses' => 'RestaurantController@delete']);
  
    $router->put('restaurants/{id}', ['uses' => 'RestaurantController@update']);
  });
